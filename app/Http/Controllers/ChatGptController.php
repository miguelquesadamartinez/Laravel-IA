<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatGptController extends Controller
{
    public function index()
    {
        return view('chatgpt.index');
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => ['required', 'string', 'max:2000'],
        ]);

        $apiKey = env('OPENAI_API_KEY');
        $model = env('OPENAI_MODEL', 'gpt-4o-mini');

        if (empty($apiKey)) {
            return back()->withErrors([
                'query' => 'Falta configurar OPENAI_API_KEY en el .env.',
            ])->withInput();
        }

        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => 'Responde de forma clara y concisa.'],
                    ['role' => 'user', 'content' => $validated['query']],
                ],
                'temperature' => 0.2,
            ]);

        if (!$response->successful()) {
            $errorMessage = $response->json('error.message') ?? 'No se pudo completar la solicitud.';

            return back()->withErrors([
                'query' => $errorMessage,
            ])->withInput();
        }

        $answer = $response->json('choices.0.message.content');

        return view('chatgpt.index', [
            'answer' => $answer,
            'query' => $validated['query'],
        ]);
    }
}
