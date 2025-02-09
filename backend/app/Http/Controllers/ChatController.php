<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class ChatController extends Controller
{
    public static function index(Request $request)
    {
        $message = $request->query('message');
        return response(["message" => self::send($message)], 200)
            ->header('Content-Type', 'application/json');
    }

    public static function send($message): ?string
    {
        $yourApiKey = getenv('AI_TOKEN');
        $client = OpenAI::client($yourApiKey);

        $result = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            "store" => true,
            'messages' => [
                ['role' => 'user', 'content' => $message],
            ],
        ]);

        return $result->choices[0]->message->content;
    }
}
