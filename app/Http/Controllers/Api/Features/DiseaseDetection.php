<?php

namespace App\Http\Controllers\Api\Features;

use App\Http\Controllers\Controller;
use Http;
use Illuminate\Http\Request;

class DiseaseDetection extends Controller
{
    public function prediction(Request $request)
    {
        $request->validate(
            [
                'image' => 'required|image|max:2048'
            ]
        );
        $file = $request->file('image'); 
        $url = env('FLASK_URL');

        $response = Http::attach(
            'file',
            file_get_contents($file->getPathname()),
            $file->getClientOriginalName()
        )->post("$url/predict");

        if ($response->failed()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Flask API error',
                'flask_error' => $response->json(),

            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Klasifikasi berhasil dilakukan',
            'data' => $response->json()
        ]);
    }
}
