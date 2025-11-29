<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHomeController extends Controller
{
    // 1. Tampilkan Form Edit (Karena Home cuma 1 data, kita langsung ke edit)
    public function index()
    {
        $home = Home::first();

        // Jika data belum ada, buat dummy kosong agar tidak error
        if (!$home) {
            $home = new Home();
            $home->role = []; // Inisialisasi array kosong untuk JSON
        }

        return view('admin.home.index', compact('home'));
    }

    // 2. Simpan Perubahan (Update)
    public function update(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'role' => 'array', // Role harus berupa array
            'role.*' => 'string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'email' => 'nullable|email',
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'cv' => 'nullable|mimes:pdf|max:5120',
        ]);

        // Ambil data yang ada atau buat baru jika kosong
        $home = Home::first();
        if (!$home) {
            $home = new Home();
        }

        // Update Data Teks
        $home->nama = $request->nama;
        $home->deskripsi = $request->deskripsi;
        $home->role = array_values(array_filter($request->role)); // Hapus input kosong & reset index
        $home->github = $request->github;
        $home->linkedin = $request->linkedin;
        $home->instagram = $request->instagram;
        $home->mail = $request->email;

        if ($request->hasFile('cv')) {
            // Hapus CV lama jika ada
            if ($home->cv && file_exists(public_path($home->cv))) {
                unlink(public_path($home->cv));
            }

            $file = $request->file('cv');
            // Nama file unik: cv_time.pdf
            $filename = 'cv_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/cv'), $filename); // Simpan di folder public/storage/cv

            $home->cv = $filename;
        }

        // Handle Upload Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($home->foto && file_exists(public_path($home->foto))) {
                unlink(public_path($home->foto));
            }

            // Simpan foto baru ke public/img
            $file = $request->file('foto');
            $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/home'), $filename);

            $home->foto = $filename;
        }

        $home->save();

        return redirect()->route('admin.home.index')->with('success', 'Profile updated successfully!');
    }
}