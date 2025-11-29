<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('admin.project.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.project.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'type' => 'required|string',
            'deskripsi' => 'required|string',
            'client' => 'nullable|string',
            'role' => 'nullable|string',
            'tanggal' => 'required|date',
            'website' => 'nullable|url',
            'source' => 'nullable|url',

            // Validasi Array
            'teknologi' => 'array',
            'teknologi.*' => 'string',
            'fitur' => 'array',
            'fitur.*' => 'string',

            // Validasi Gambar (Multiple)
            'galery' => 'nullable|array',
            'galery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $project = new Project($request->except(['galery']));

        // Generate Slug otomatis
        $project->slug = Str::slug($request->judul);

        // Handle Multiple Image Upload
        $imagePaths = [];
        if ($request->hasFile('galery')) {
            foreach ($request->file('galery') as $image) {
                $filename = 'p_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img/project'), $filename);
                $imagePaths[] = $filename;
            }
        }
        $project->galery = $imagePaths;

        // Array input lain (teknologi & fitur) otomatis dicasting oleh Model karena nama fieldnya sama

        $project->save();

        return redirect()->route('admin.project.index')->with('success', 'Project created successfully!');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('admin.project.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'galery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $project->fill($request->except(['galery']));
        $project->slug = Str::slug($request->judul);

        // Handle Image Update (Append or Replace logic)
        // Di sini logikanya: Jika ada upload baru, gambar lama DIGANTI total.
        // Jika ingin menambah, logikanya harus diubah sedikit.
        if ($request->hasFile('galery')) {
            // 1. Hapus gambar lama
            if ($project->galery) {
                foreach ($project->galery as $oldImg) {
                    if (File::exists(public_path($oldImg))) {
                        File::delete(public_path($oldImg));
                    }
                }
            }

            // 2. Upload gambar baru
            $imagePaths = [];
            foreach ($request->file('galery') as $image) {
                $filename = 'p_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img/project'), $filename);
                $imagePaths[] = $filename;
            }
            $project->galery = $imagePaths;
        }

        $project->save();

        return redirect()->route('admin.project.index')->with('success', 'Project updated successfully!');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // Hapus semua gambar terkait
        if ($project->galery) {
            foreach ($project->galery as $image) {
                if (File::exists(public_path($image))) {
                    File::delete(public_path($image));
                }
            }
        }

        $project->delete();

        return redirect()->route('admin.project.index')->with('success', 'Project deleted!');
    }
}