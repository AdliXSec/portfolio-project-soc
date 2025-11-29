<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminCertificateController extends Controller
{
    public function index()
    {
        // Urutkan berdasarkan tanggal terbaru
        $certificates = Certificate::orderBy('tanggal', 'desc')->get();
        return view('admin.certificate.index', compact('certificates'));
    }

    public function create()
    {
        return view('admin.certificate.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'type' => 'required|string', // Award / Certificate
            'issued' => 'required|string', // Penerbit
            'tanggal' => 'required|date',
            'kredensial' => 'nullable|string',
            'link' => 'nullable|url',
            'status' => 'required|string',
            'deskripsi' => 'nullable|string',

            'skill' => 'nullable|array',
            'skill.*' => 'string',

            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $cert = new Certificate($request->except(['foto']));
        $cert->slug = Str::slug($request->judul);

        // Handle Upload Foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'cert_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/cert'), $filename);
            $cert->foto = $filename;
        }

        // Skill array otomatis dicasting oleh Model
        $cert->save();

        return redirect()->route('admin.certificate.index')->with('success', 'Certificate added successfully!');
    }

    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('admin.certificate.edit', compact('certificate'));
    }

    public function update(Request $request, $id)
    {
        $cert = Certificate::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $cert->fill($request->except(['foto']));
        $cert->slug = Str::slug($request->judul);

        // Handle Image Update
        if ($request->hasFile('foto')) {
            // Hapus gambar lama
            if ($cert->foto && File::exists(public_path($cert->foto))) {
                File::delete(public_path($cert->foto));
            }

            $file = $request->file('foto');
            $filename = 'cert_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/cert'), $filename);
            $cert->foto = $filename;
        }

        // Bersihkan array skill dari input kosong
        if ($request->has('skill')) {
            $cert->skill = array_values(array_filter($request->skill));
        }

        $cert->save();

        return redirect()->route('admin.certificate.index')->with('success', 'Certificate updated successfully!');
    }

    public function destroy($id)
    {
        $cert = Certificate::findOrFail($id);

        if ($cert->foto && File::exists(public_path($cert->foto))) {
            File::delete(public_path($cert->foto));
        }

        $cert->delete();

        return redirect()->route('admin.certificate.index')->with('success', 'Certificate deleted!');
    }
}
