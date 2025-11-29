<?php

namespace App\Http\Controllers;

use App\Models\Tech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Untuk hapus file gambar

class AdminTechController extends Controller
{
    // 1. Tampilkan Daftar Tech
    public function index()
    {
        $techs = Tech::all();
        return view('admin.tech.index', compact('techs'));
    }

    // 2. Tampilkan Form Tambah
    public function create()
    {
        return view('admin.tech.create');
    }

    // 3. Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:50',
            'foto' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048', // Wajib ada gambar/logo
        ]);

        $tech = new Tech();
        $tech->judul = $request->judul;

        // Upload Logo ke folder public/img/code
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = strtolower($request->judul) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/code'), $filename);
            $tech->foto = $filename;
        }

        $tech->save();

        return redirect()->route('admin.tech.index')->with('success', 'New technology added successfully!');
    }

    // 4. Tampilkan Form Edit
    public function edit($id)
    {
        $tech = Tech::findOrFail($id);
        return view('admin.tech.edit', compact('tech'));
    }

    // 5. Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $tech = Tech::findOrFail($id);
        $tech->judul = $request->judul;

        if ($request->hasFile('foto')) {
            // Hapus gambar lama
            if ($tech->foto && File::exists(public_path($tech->foto))) {
                File::delete(public_path($tech->foto));
            }

            $file = $request->file('foto');
            $filename = strtolower($request->judul) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/code'), $filename);
            $tech->foto = $filename;
        }

        $tech->save();

        return redirect()->route('admin.tech.index')->with('success', 'Technology updated successfully!');
    }

    // 6. Hapus Data
    public function destroy($id)
    {
        $tech = Tech::findOrFail($id);

        // Hapus gambar dari folder
        if ($tech->foto && File::exists(public_path($tech->foto))) {
            File::delete(public_path($tech->foto));
        }

        $tech->delete();

        return redirect()->route('admin.tech.index')->with('success', 'Technology deleted!');
    }
}