<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            'type' => 'required|string|in:Web Development,IoT,Cyber Security,Mobile App',
            'deskripsi' => 'required|string|max:10000',
            'client' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'website' => 'nullable|url|max:500',
            'source' => 'nullable|url|max:500',
            'teknologi' => 'nullable|array|max:20',
            'teknologi.*' => 'string|max:50',
            'fitur' => 'nullable|array|max:20',
            'fitur.*' => 'string|max:255',
            'galery' => 'nullable|array|max:10',
            'galery.*' => 'image|mimes:jpeg,png,jpg,webp|max:5048'
        ]);

        // Sanitasi input
        $data = $request->except(['galery', '_token']);
        $data['judul'] = strip_tags($data['judul']);
        $data['deskripsi'] = strip_tags($data['deskripsi'], '<p><br><strong><em><ul><ol><li>');

        $project = new Project($data);
        $project->slug = Str::slug($request->judul);

        $imagePaths = [];
        if ($request->hasFile('galery')) {
            foreach ($request->file('galery') as $image) {
                // Validasi tambahan: cek real MIME type
                $realMime = $image->getMimeType();
                if (!in_array($realMime, ['image/jpeg', 'image/png', 'image/webp'])) {
                    continue;
                }

                $filename = 'p_' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('project', $image, $filename);
                $imagePaths[] = $filename;
            }
        }
        $project->galery = $imagePaths;

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
            'type' => 'required|string|in:Web Development,IoT,Cyber Security,Mobile App',
            'deskripsi' => 'required|string|max:10000',
            'client' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'website' => 'nullable|url|max:500',
            'source' => 'nullable|url|max:500',
            'teknologi' => 'nullable|array|max:20',
            'teknologi.*' => 'string|max:50',
            'fitur' => 'nullable|array|max:20',
            'fitur.*' => 'string|max:255',
            'galery' => 'nullable|array|max:10',
            'galery.*' => 'image|mimes:jpeg,png,jpg,webp|max:5048'
        ]);

        // Sanitasi input
        $data = $request->except(['galery', '_token', '_method']);
        $data['judul'] = strip_tags($data['judul']);
        $data['deskripsi'] = strip_tags($data['deskripsi'], '<p><br><strong><em><ul><ol><li>');

        $project->fill($data);
        $project->slug = Str::slug($request->judul);

        if ($request->hasFile('galery')) {
            if ($project->galery) {
                foreach ($project->galery as $oldImg) {
                    if (Storage::disk('public')->exists('project/' . $oldImg)) {
                        Storage::disk('public')->delete('project/' . $oldImg);
                    }
                }
            }

            $imagePaths = [];
            foreach ($request->file('galery') as $image) {
                // Validasi tambahan: cek real MIME type
                $realMime = $image->getMimeType();
                if (!in_array($realMime, ['image/jpeg', 'image/png', 'image/webp'])) {
                    continue;
                }

                $filename = 'p_' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('project', $image, $filename);
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

        if ($project->galery) {
            foreach ($project->galery as $image) {
                if (Storage::disk('public')->exists('project/' . $image)) {
                    Storage::disk('public')->delete('project/' . $image);
                }
            }
        }

        $project->delete();

        return redirect()->route('admin.project.index')->with('success', 'Project deleted!');
    }
}