<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use Illuminate\Http\Request;

class AdminJourneyController extends Controller
{
    // 1. Tampilkan Daftar Journey
    public function index()
    {
        // Urutkan dari yang terbaru (ID terbesar/terakhir diinput)
        $journeys = Journey::orderBy('id', 'desc')->get();
        return view('admin.journey.index', compact('journeys'));
    }

    // 3. Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:50', // Contoh: "2024 - Present"
            'judul' => 'required|string|max:255', // Contoh: "Backend Developer"
            'deskripsi' => 'required|string',
        ]);

        Journey::create($request->all());

        return redirect()->route('admin.journey.index')->with('success', 'New journey added successfully!');
    }

    // 4. Form Edit
    public function edit($id)
    {
        $journey = Journey::findOrFail($id);
        return view('admin.journey.edit', compact('journey'));
    }

    // 5. Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|string|max:50',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $journey = Journey::findOrFail($id);
        $journey->update($request->all());

        return redirect()->route('admin.journey.index')->with('success', 'Journey updated successfully!');
    }

    // 6. Hapus Data
    public function destroy($id)
    {
        $journey = Journey::findOrFail($id);
        $journey->delete();

        return redirect()->route('admin.journey.index')->with('success', 'Journey deleted successfully!');
    }
}