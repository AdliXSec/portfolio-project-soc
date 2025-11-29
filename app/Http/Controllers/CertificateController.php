<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function show(Certificate $certificate)
    {
        // 1. Ambil sertifikat utama
        $related_certificates = Certificate::where('id', '!=', $certificate->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('certificates.show', compact('certificate', 'related_certificates'));
    }
}
