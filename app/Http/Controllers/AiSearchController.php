<?php

namespace App\Http\Controllers;

use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class AiSearchController extends Controller
{
    protected AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index(string $provider)
    {
        $label = $this->labelFor($provider);

        return view('ai.index', [
            'provider' => $provider,
            'providerLabel' => $label,
        ]);
    }

    public function search(Request $request, string $provider)
    {
        $label = $this->labelFor($provider);

        $validated = $request->validate([
            'query' => ['required', 'string', 'max:2000'],
        ]);

        $envKey = AiService::PROVIDER_ENV_KEYS[$provider] ?? null;
        $apiKey = $envKey ? env($envKey) : null;

        if ($provider !== 'ollama' && empty($apiKey)) {
            return back()->withErrors([
                'query' => "Usa tu llave de {$label} en el .env.",
            ])->withInput();
        }

        try {
            $answer = $this->aiService->callProvider($provider, $validated['query'], $apiKey);
        } catch (Throwable $e) {
            Log::error("Error en {$provider}: " . $e->getMessage());

            $message = strtolower($e->getMessage());
            $isQuotaError = str_contains($message, 'quota')
                || str_contains($message, 'billing')
                || str_contains($message, 'plan');

            $errorMessage = $isQuotaError
                ? "Usa tu llave de {$label} en el .env."
                : 'No se pudo completar la solicitud.';

            return back()->withErrors([
                'query' => $errorMessage,
            ])->withInput();
        }

        return view('ai.index', [
            'answer' => $answer,
            'query' => $validated['query'],
            'provider' => $provider,
            'providerLabel' => $label,
        ]);
    }

    private function labelFor(string $provider): string
    {
        if (!array_key_exists($provider, AiService::PROVIDERS)) {
            abort(404);
        }

        return AiService::PROVIDERS[$provider];
    }
}

