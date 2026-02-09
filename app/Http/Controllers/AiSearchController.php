<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class AiSearchController extends Controller
{
    private const PROVIDERS = [
        'openai' => 'OpenAI',
        'anthropic' => 'Anthropic',
        'gemini' => 'Gemini',
        'groq' => 'Groq',
        'xai' => 'xAI',
        'deepseek' => 'DeepSeek',
        'mistral' => 'Mistral',
        'ollama' => 'Ollama',
    ];

    private const PROVIDER_ENV_KEYS = [
        'openai' => 'OPENAI_API_KEY',
        'anthropic' => 'ANTHROPIC_API_KEY',
        'gemini' => 'GEMINI_API_KEY',
        'groq' => 'GROQ_API_KEY',
        'xai' => 'XAI_API_KEY',
        'deepseek' => 'DEEPSEEK_API_KEY',
        'mistral' => 'MISTRAL_API_KEY',
        'ollama' => 'OLLAMA_API_KEY',
    ];

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

        $envKey = self::PROVIDER_ENV_KEYS[$provider] ?? null;
        $apiKey = $envKey ? env($envKey) : null;

        //Log::info("Using label: {$label} with API key from env key: {$envKey}");

        if ($provider !== 'ollama' && empty($apiKey)) {
            return back()->withErrors([
                'query' => "Usa tu llave de {$label} en el .env.",
            ])->withInput();
        }

        try {
            $answer = $this->callProvider($provider, $validated['query'], $apiKey);
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
        if (!array_key_exists($provider, self::PROVIDERS)) {
            abort(404);
        }

        return self::PROVIDERS[$provider];
    }

    private function callProvider(string $provider, string $query, ?string $apiKey): string
    {
        return match ($provider) {
            'openai' => $this->callOpenAI($query, $apiKey),
            'anthropic' => $this->callAnthropic($query, $apiKey),
            'gemini' => $this->callGemini($query, $apiKey),
            'groq' => $this->callGroq($query, $apiKey),
            'xai' => $this->callXAI($query, $apiKey),
            'deepseek' => $this->callDeepSeek($query, $apiKey),
            'mistral' => $this->callMistral($query, $apiKey),
            'ollama' => $this->callOllama($query),
            default => throw new \Exception('Provider not supported'),
        };
    }

    private function callOpenAI(string $query, string $apiKey): string
    {
        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'Responde de forma clara y concisa.'],
                    ['role' => 'user', 'content' => $query],
                ],
                'temperature' => 0.2,
            ]);

        if (!$response->successful()) {
            throw new \Exception($response->json('error.message') ?? 'Error al llamar a OpenAI');
        }

        return $response->json('choices.0.message.content');
    }

    private function callAnthropic(string $query, string $apiKey): string
    {
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'anthropic-version' => '2023-06-01',
        ])
            ->timeout(30)
            ->post('https://api.anthropic.com/v1/messages', [
                'model' => 'claude-3-5-sonnet-20241022',
                'max_tokens' => 1024,
                'messages' => [
                    ['role' => 'user', 'content' => $query],
                ],
            ]);

        if (!$response->successful()) {
            throw new \Exception($response->json('error.message') ?? 'Error al llamar a Anthropic');
        }

        return $response->json('content.0.text');
    }

    private function callGemini(string $query, string $apiKey): string
    {
        $response = Http::timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    ['parts' => [['text' => $query]]],
                ],
            ]);

        if (!$response->successful()) {
            throw new \Exception($response->json('error.message') ?? 'Error al llamar a Gemini');
        }

        return $response->json('candidates.0.content.parts.0.text');
    }

    private function callGroq(string $query, string $apiKey): string
    {
        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    ['role' => 'system', 'content' => 'Responde de forma clara y concisa.'],
                    ['role' => 'user', 'content' => $query],
                ],
                'temperature' => 0.2,
            ]);

        if (!$response->successful()) {
            throw new \Exception($response->json('error.message') ?? 'Error al llamar a Groq');
        }

        return $response->json('choices.0.message.content');
    }

    private function callXAI(string $query, string $apiKey): string
    {
        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post('https://api.x.ai/v1/chat/completions', [
                'model' => 'grok-beta',
                'messages' => [
                    ['role' => 'system', 'content' => 'Responde de forma clara y concisa.'],
                    ['role' => 'user', 'content' => $query],
                ],
                'temperature' => 0.2,
            ]);

        if (!$response->successful()) {
            throw new \Exception($response->json('error.message') ?? 'Error al llamar a xAI');
        }

        return $response->json('choices.0.message.content');
    }

    private function callDeepSeek(string $query, string $apiKey): string
    {
        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post('https://api.deepseek.com/v1/chat/completions', [
                'model' => 'deepseek-chat',
                'messages' => [
                    ['role' => 'system', 'content' => 'Responde de forma clara y concisa.'],
                    ['role' => 'user', 'content' => $query],
                ],
                'temperature' => 0.2,
            ]);

        if (!$response->successful()) {
            throw new \Exception($response->json('error.message') ?? 'Error al llamar a DeepSeek');
        }

        return $response->json('choices.0.message.content');
    }

    private function callMistral(string $query, string $apiKey): string
    {
        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post('https://api.mistral.ai/v1/chat/completions', [
                'model' => 'mistral-small-latest',
                'messages' => [
                    ['role' => 'system', 'content' => 'Responde de forma clara y concisa.'],
                    ['role' => 'user', 'content' => $query],
                ],
                'temperature' => 0.2,
            ]);

        if (!$response->successful()) {
            throw new \Exception($response->json('error.message') ?? 'Error al llamar a Mistral');
        }

        return $response->json('choices.0.message.content');
    }

    private function callOllama(string $query): string
    {
        $baseUrl = env('OLLAMA_BASE_URL', 'http://localhost:11434');
        $model = env('OLLAMA_MODEL', 'llama2');

        $response = Http::timeout(30)
            ->post("{$baseUrl}/api/generate", [
                'model' => $model,
                'prompt' => $query,
                'stream' => false,
            ]);

        if (!$response->successful()) {
            throw new \Exception('Error al llamar a Ollama');
        }

        return $response->json('response');
    }
}
