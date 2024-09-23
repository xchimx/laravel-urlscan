<?php

namespace Xchimx\LaravelUrlScan;

use Illuminate\Support\Facades\Http;

class User
{
    public function getQuotas()
    {
        $apiKey = app('urlscan.api_key');

        if (empty($apiKey)) {
            return response()->json(['error' => 'API key is missing or invalid.'], 500);
        }

        $response = Http::withHeaders([
            'API-Key' => $apiKey,
        ])->get('https://urlscan.io/user/quotas/');

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json([
                'error' => 'Failed to retrieve quota information',
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }
    }
}
