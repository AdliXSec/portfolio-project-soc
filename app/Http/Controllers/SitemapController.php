<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Certificate;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $projects = Project::select('slug', 'updated_at')->get();
        $certificates = Certificate::select('slug', 'updated_at')->get();

        $content = view('sitemap.index', compact('projects', 'certificates'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
