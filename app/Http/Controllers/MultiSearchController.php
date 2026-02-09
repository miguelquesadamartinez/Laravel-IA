<?php

namespace App\Http\Controllers;

use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class MultiSearchController extends Controller
{
    protected AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index()
    {
        return view('multi-search.index');
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => ['required', 'string', 'max:2000'],
        ]);

        $query = $validated['query'];
        $results = [];
        $errors = [];

        // 1. Query all providers
        foreach (AiService::PROVIDERS as $key => $label) {
            try {
                // Skip if no API key is configured (except Ollama)
                $envKey = AiService::PROVIDER_ENV_KEYS[$key] ?? null;
                $apiKey = $envKey ? env($envKey) : null;

                if ($key !== 'ollama' && empty($apiKey)) {
                     // Notify that it was skipped due to missing config
                     $errors[$label] = "No configurado (falta {$envKey})";
                     continue;
                }

                $response = $this->aiService->callProvider($key, $query, $apiKey);
                $results[$label] = $response;

            } catch (Throwable $e) {
                Log::error("MultiSearch error for {$label}: " . $e->getMessage());
                // We just log and skip to allow partial results
                $errors[$label] = $e->getMessage();
            }
        }

        if (empty($results)) {
            return back()->withErrors(['query' => 'No se pudo obtener respuesta de ninguna IA configurada.']);
        }

        // 2. Summarize with Gemini
        $summary = null;
        try {
            $summaryPrompt = "Actúa como un validador de resultados. He realizado la consulta: \"{$query}\" a varias IAs y he obtenido los siguientes resultados:\n\n";
            foreach ($results as $provider => $text) {
                $summaryPrompt .= "--- Resultado de {$provider} ---\n{$text}\n\n";
            }
            $summaryPrompt .= "Tu tarea es:\n" .
                "1. Generar una CONCLUSIÓN FINAL verificada basada en el consenso de estos resultados.\n" .
                "2. Analizar si existen CONTRADICCIONES FACTUALES o de datos (ignora diferencias de redacción, estilo o longitud).\n" .
                "No analices el texto en sí, céntrate en la veracidad y consistencia de la información obtenida.\n" .
                "Responde en español.";

            // Use Gemini for summary as requested, fallback to others if needed?
            // User specifically asked "envie a gemini los resultados buenos".

            // Need Gemini API Key
            $geminiKey = env('GEMINI_API_KEY');
            if ($geminiKey) {
                 $summary = $this->aiService->callProvider('gemini', $summaryPrompt, $geminiKey);
            } else {
                $summary = "No se puede generar el resumen porque falta la API Key de Gemini.";
            }

        } catch (Throwable $e) {
             $summary = "Error generando el resumen: " . $e->getMessage();
        }

        return view('multi-search.index', [
            'query' => $query,
            'summary' => $summary,
            'results' => $results,
            'aiErrors' => $errors
        ]);
    }
}
