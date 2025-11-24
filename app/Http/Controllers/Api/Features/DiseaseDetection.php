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

        $classId = $response->json()['class_id'];

        $diseaseTreatment = match ($classId) {
            0 => [''],
            1 => [
                'Cuci area dengan sabun lembut, keringkan benar-benar.',
                'Gunakan krim antijamur OTC (yang mengandung clotrimazole/ketoconazole/terbinafine) sesuai petunjuk kemasan.',
                'Hindari menggosok terlalu keras untuk mencegah iritasi.',
                'Bila muncul di telapak tangan/kaki tapi tidak menimbulkan rasa sakit, tetap aman menunda ke klinik 1-2 hari sambil observasi.',
                'Pantau perubahan warna: bila warna bertambah gelap, melebar cepat, atau bentuknya tidak simetris'
            ],
            2 => [
                'Gunakan krim antijamur OTC (clotrimazole/terbinafine) pada area bercak merah berbentuk cincin.',
                'Jaga area tetap kering dan bersih.',
                'Cuci pakaian, handuk, dan sprei yang bersentuhan dengan lesi untuk mencegah penularan ulang.',
                'Hindari garukan agar tidak menyebar ke area lain.',
                'Hindari penggunaan steroid topikal (salep merah/salep kombinasi dengan steroid) karena dapat memperburuk ringworm.'
            ],
            3 => [
                'Gunakan sampo antijamur OTC (mis. ketoconazole/shampoo sulfur selenium) sebagai body wash pada area berbintik',
                'Jaga kulit tetap kering setelah mandi.',
                'Hindari keringat berlebihan (mis. olahraga berat) untuk sementara',
                'Gunakan pakaian longgar dan berbahan katun.',
            ],
            default => [''],
        };

        return response()->json([
            'status' => 'success',
            'message' => 'Klasifikasi berhasil dilakukan',
            'data' => [
                'prediction' => $response->json(),
                'treatment' => $diseaseTreatment,
            ]
        ]);
    }
}
