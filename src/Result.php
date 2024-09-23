<?php

namespace Xchimx\LaravelUrlScan;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class Result
{
    public function getResult(string $uuid)
    {
        $validator = Validator::make([
            'uuid' => $uuid,
        ], [
            'uuid' => 'required|uuid',
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
        ])->get("https://urlscan.io/api/v1/result/$uuid/");

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json([
                'error' => 'Failed to retrieve results',
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }
    }

    public function getScreenshot(string $uuid)
    {
        $validator = Validator::make([
            'uuid' => $uuid,
        ], [
            'uuid' => 'required|uuid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $screenshotUrl = "https://urlscan.io/screenshots/$uuid.png";
        $domSnapshotUrl = "https://urlscan.io/dom/$uuid";

        return response()->json([
            'screenshot' => $screenshotUrl,
            'dom_snapshot' => $domSnapshotUrl,
        ]);
    }
}
