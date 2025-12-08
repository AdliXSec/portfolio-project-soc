<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHomeController extends Controller
{
    public function index()
    {
        $home = Home::first();

        if (!$home) {
            $home = new Home();
            $home->role = [];
        }

        return view('admin.home.index', compact('home'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'role' => 'array',
            'role.*' => 'string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            'email' => 'nullable|email',
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'cv' => 'nullable|mimes:pdf|max:5120',
        ]);

        $home = Home::first();
        if (!$home) {
            $home = new Home();
        }

        $home->nama = $request->nama;
        $home->deskripsi = $request->deskripsi;
        $home->role = array_values(array_filter($request->role));
        $home->github = $request->github;
        $home->linkedin = $request->linkedin;
        $home->instagram = $request->instagram;
        $home->mail = $request->email;

        if ($request->hasFile('cv')) {
            if ($home->cv && Storage::disk('public')->exists('cv/' . $home->cv)) {
                Storage::disk('public')->delete('cv/' . $home->cv);
            }

            $file = $request->file('cv');
            $filename = 'cv_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('cv', $file, $filename);

            $home->cv = $filename;
        }

        if ($request->hasFile('foto')) {
            if ($home->foto && Storage::disk('public')->exists('home/' . $home->foto)) {
                Storage::disk('public')->delete('home/' . $home->foto);
            }

            $file = $request->file('foto');
            $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('home', $file, $filename);

            $home->foto = $filename;
        }

        $home->save();

        return redirect()->route('admin.home.index')->with('success', 'Profile updated successfully!');
    }
}
