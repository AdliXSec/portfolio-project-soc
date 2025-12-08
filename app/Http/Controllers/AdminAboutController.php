<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAboutController extends Controller
{
    public function index()
    {
        $about = About::first();

        if (!$about) {
            $about = new About();
            $about->core = [];
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
            'core' => 'array',
            'core.*' => 'string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $about = About::first();
        if (!$about) {
            $about = new About();
        }

        $about->judul = $request->judul;
        $about->subjudul = $request->subjudul;
        $about->deskripsi = $request->deskripsi;
        $about->total_project = $request->total_project;
        $about->core = array_values(array_filter($request->core));

        if ($request->hasFile('foto')) {
            if ($about->foto && Storage::disk('public')->exists('about/' . $about->foto)) {
                Storage::disk('public')->delete('about/' . $about->foto);
            }

            $file = $request->file('foto');
            $filename = 'about_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('about', $file, $filename);

            $about->foto = $filename;
        }

        $about->save();

        return redirect()->route('admin.about.index')->with('success', 'About section updated successfully!');
    }
}