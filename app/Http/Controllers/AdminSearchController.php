<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Certificate;

class AdminSearchController extends Controller
{
    public function search(Request $request)
    {
        // Validasi dan sanitasi input
        $request->validate([
            'query' => 'required|string|max:100'
        ]);

        $query = strip_tags(trim($request->input('query')));

        // Batasi panjang query
        $query = substr($query, 0, 100);

        // If query is empty after sanitasi, redirect back
        if (empty($query)) {
            return redirect()->back();
        }

        // Search in Projects (Title or Description) - Eloquent sudah protect dari SQL Injection
        $projects = Project::where('judul', 'LIKE', "%{$query}%")
            ->orWhere('deskripsi', 'LIKE', "%{$query}%")
            ->limit(50)
            ->get();

        // Search in Certificates (Title or Issuer)
        $certificates = Certificate::where('judul', 'LIKE', "%{$query}%")
            ->orWhere('issued', 'LIKE', "%{$query}%")
            ->limit(50)
            ->get();

        return view('admin.search.results', compact('projects', 'certificates', 'query'));
    }
}
