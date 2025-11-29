<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // Mulai Query
        $query = Project::query();

        // 1. Filter Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('type', 'like', '%' . $request->category . '%');
        }

        // 3. Ambil data dengan Pagination (9 per halaman)
        $projects = $query->latest()->paginate(9);

        // Jika ada filter, append query string ke pagination link
        $projects->appends($request->all());

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        // Cari project berdasarkan ID, jika tidak ada tampilkan 404
        return view('projects.show', compact('project'));
    }
}
