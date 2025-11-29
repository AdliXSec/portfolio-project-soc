<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Certificate;

class AdminSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // If query is empty, redirect back
        if (!$query) {
            return redirect()->back();
        }

        // Search in Projects (Title or Description)
        $projects = Project::where('judul', 'LIKE', "%{$query}%")
            ->orWhere('deskripsi', 'LIKE', "%{$query}%")
            ->get();

        // Search in Certificates (Title or Issuer)
        $certificates = Certificate::where('judul', 'LIKE', "%{$query}%")
            ->orWhere('issued', 'LIKE', "%{$query}%")
            ->get();

        return view('admin.search.results', compact('projects', 'certificates', 'query'));
    }
}
