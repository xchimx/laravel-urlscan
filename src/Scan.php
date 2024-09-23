<?php

namespace Xchimx\LaravelUrlScan;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class Scan
{
    public function submitUrl(string $url, string $visibility)
    {
        $validator = Validator::make([
            'url' => $url,
            'visibility' => $visibility,
        ], [
            'url' => 'required|url',
            'visibility' => 'required|in:public,private,unlisted',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $apiKey = app('urlscan.api_key');

        if (empty($apiKey)) {
            return response()->json(['error' => 'API key is missing or invalid.'], 500);
        }

        $response = Http::withHeaders([
            'API-Key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://urlscan.io/api/v1/scan/', [
            'url' => $url,
            'visibility' => 'public',
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json([
                'error' => 'Scan failed',
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }
    }
}
