<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{

    protected static function normalizePhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) == '0') {

            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }


    public static function send(
        $target,
        $message
    ) {

        try {

            $target =
                self::normalizePhone($target);

            $response = Http::withoutVerifying()

                ->withHeaders([

                    'Authorization' =>
                    env('FONNTE_TOKEN')

                ])

                ->asForm()

                ->post(

                    'https://api.fonnte.com/send',

                    [

                        'target' =>
                        $target,

                        'message' =>
                        $message,
                    ]
                );

            Log::info(
                'Fonnte Text Success',
                $response->json()
            );
        } catch (\Exception $e) {

            Log::error(
                'Fonnte Text Error: ' .
                    $e->getMessage()
            );
        }
    }

    public static function sendDocument(
        $target,
        $fileUrl,
        $caption = ''
    ) {

        try {

            $target =
                self::normalizePhone($target);

            $response = Http::withoutVerifying()

                ->withHeaders([

                    'Authorization' =>
                    env('FONNTE_TOKEN')

                ])

                ->asForm()

                ->post(

                    'https://api.fonnte.com/send',

                    [

                        'target' =>
                        $target,

                        'url' =>
                        $fileUrl,

                        'filename' =>
                        'receipt.pdf',

                        'caption' =>
                        $caption,
                    ]
                );

            Log::info(
                'Fonnte Document Success',
                $response->json()
            );
        } catch (\Exception $e) {

            Log::error(
                'Fonnte Document Error: ' .
                    $e->getMessage()
            );
        }
    }

    public static function sendImage(
        $target,
        $imageUrl,
        $caption = ''
    ) {

        try {

            $target =
                self::normalizePhone($target);

            $response = Http::withoutVerifying()

                ->withHeaders([

                    'Authorization' =>
                    env('FONNTE_TOKEN')

                ])

                ->asForm()

                ->post(

                    'https://api.fonnte.com/send',

                    [

                        'target' =>
                        $target,

                        'url' =>
                        $imageUrl,

                        'caption' =>
                        $caption,
                    ]
                );

            Log::info(
                'Fonnte Image Success',
                $response->json()
            );
        } catch (\Exception $e) {

            Log::error(
                'Fonnte Image Error: ' .
                    $e->getMessage()
            );
        }
    }
}
