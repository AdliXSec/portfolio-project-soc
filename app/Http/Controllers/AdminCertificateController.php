<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminCertificateController extends Controller
{
    public function index()
    {
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
            'type' => 'required|string',
            'issued' => 'required|string',
            'tanggal' => 'required|date',
            'kredensial' => 'nullable|string',
            'link' => 'nullable|url',
            'status' => 'required|string',
            'deskripsi' => 'nullable|string',
            'skill' => 'nullable|array',
            'skill.*' => 'string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $cert = new Certificate($request->except(['foto']));
        $cert->slug = Str::slug($request->judul);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'cert_' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('certificate', $file, $filename);
            $cert->foto = $filename;
        }

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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $cert->fill($request->except(['foto']));
        $cert->slug = Str::slug($request->judul);

        if ($request->hasFile('foto')) {
            if ($cert->foto && Storage::disk('public')->exists('certificate/' . $cert->foto)) {
                Storage::disk('public')->delete('certificate/' . $cert->foto);
            }

            $file = $request->file('foto');
            $filename = 'cert_' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('certificate', $file, $filename);
            $cert->foto = $filename;
        }

        if ($request->has('skill')) {
            $cert->skill = array_values(array_filter($request->skill));
        }

        $cert->save();

        return redirect()->route('admin.certificate.index')->with('success', 'Certificate updated successfully!');
    }

    public function destroy($id)
    {
        $cert = Certificate::findOrFail($id);

        if ($cert->foto && Storage::disk('public')->exists('certificate/' . $cert->foto)) {
            Storage::disk('public')->delete('certificate/' . $cert->foto);
        }

        $cert->delete();

        return redirect()->route('admin.certificate.index')->with('success', 'Certificate deleted!');
    }
}