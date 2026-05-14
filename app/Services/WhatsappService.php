<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    public static function send($target, $message)
    {
        try {

            Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => env('FONNTE_TOKEN')
                ])
                ->post('https://api.fonnte.com/send', [
                    'target'  => $target,
                    'message' => $message,
                ]);
        } catch (\Exception $e) {

            Log::error('Fonnte Error: ' . $e->getMessage());
        }
    }
}
