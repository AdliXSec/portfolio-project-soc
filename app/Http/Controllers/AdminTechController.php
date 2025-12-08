<?php

namespace App\Http\Controllers;

use App\Models\Tech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminTechController extends Controller
{
    public function index()
    {
        $techs = Tech::all();
        return view('admin.tech.index', compact('techs'));
    }

    public function create()
    {
        return view('admin.tech.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:50',
            'foto' => 'required|image|mimes:png,jpg,jpeg,svg|max:5048',
        ]);

        $tech = new Tech();
        $tech->judul = $request->judul;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = strtolower($request->judul) . '_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('tech', $file, $filename);
            $tech->foto = $filename;
        }

        $tech->save();

        return redirect()->route('admin.tech.index')->with('success', 'New technology added successfully!');
    }

    public function edit($id)
    {
        $tech = Tech::findOrFail($id);
        return view('admin.tech.edit', compact('tech'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5048',
        ]);

        $tech = Tech::findOrFail($id);
        $tech->judul = $request->judul;

        if ($request->hasFile('foto')) {
            if ($tech->foto && Storage::disk('public')->exists('tech/' . $tech->foto)) {
                Storage::disk('public')->delete('tech/' . $tech->foto);
            }

            $file = $request->file('foto');
            $filename = strtolower($request->judul) . '_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('tech', $file, $filename);
            $tech->foto = $filename;
        }

        $tech->save();

        return redirect()->route('admin.tech.index')->with('success', 'Technology updated successfully!');
    }

    public function destroy($id)
    {
        $tech = Tech::findOrFail($id);

        if ($tech->foto && Storage::disk('public')->exists('tech/' . $tech->foto)) {
            Storage::disk('public')->delete('tech/' . $tech->foto);
        }

        $tech->delete();

        return redirect()->route('admin.tech.index')->with('success', 'Technology deleted!');
    }
}