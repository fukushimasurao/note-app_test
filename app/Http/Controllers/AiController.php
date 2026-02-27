<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'body' => 'nullable|string',
        ]);

        // 記事本文がある場合はプロンプトに含める
        $userMessage = $request->input('message');
        $articleBody = $request->input('body');

        $prompt = $articleBody
            ? "以下の記事を参考に質問に答えてください。\n\n【記事本文】\n{$articleBody}\n\n【質問】\n{$userMessage}"
            : $userMessage;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key=' . env('GEMINI_API_KEY'),
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]
            );

        $text = $response->json('candidates.0.content.parts.0.text');

        return response()->json(['reply' => $text]);
    }
}
