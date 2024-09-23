<?php

namespace Xchimx\LaravelUrlScan;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class Search
{
    public function search(string $query)
    {
        $validator = Validator::make([
            'query' => $query,
        ], [
            'query' => 'required|string',
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
        ])->get('https://urlscan.io/api/v1/search/', [
            'q' => $query,
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json([
                'error' => 'Search failed',
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }
    }
}
