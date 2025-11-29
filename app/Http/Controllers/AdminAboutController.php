<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AdminAboutController extends Controller
{
    public function index()
    {
        // Ambil data pertama
        $about = About::first();

        // Jika data kosong, buat objek baru agar form tidak error
        if (!$about) {
            $about = new About();
            $about->core = []; // Inisialisasi array kosong
        }

        return view('admin.about.index', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'total_project' => 'required|integer|min:0',
            'core' => 'array', // Validasi array untuk skill
            'core.*' => 'string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $about = About::first();
        if (!$about) {
            $about = new About();
        }

        $about->judul = $request->judul;
        $about->subjudul = $request->subjudul;
        $about->deskripsi = $request->deskripsi;
        $about->total_project = $request->total_project;

        // Bersihkan array dari nilai null/kosong
        $about->core = array_values(array_filter($request->core));

        // Handle Upload Foto
        if ($request->hasFile('foto')) {
            if ($about->foto && file_exists(public_path($about->foto))) {
                unlink(public_path($about->foto));
            }

            $file = $request->file('foto');
            $filename = 'about_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/about'), $filename);

            $about->foto = $filename;
        }

        $about->save();

        return redirect()->route('admin.about.index')->with('success', 'About section updated successfully!');
    }
}
