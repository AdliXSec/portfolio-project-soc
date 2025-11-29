<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Untuk kirim ke Telegram
use App\Models\Home;
use App\Models\About;
use App\Models\Tech;
use App\Models\Journey;
use App\Models\Project;
use App\Models\Certificate;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Profile
        $profile = Home::first();

        // 2. Ambil Data About
        $about = About::first();

        // 3. Ambil Data Skill/Tech
        $techs = Tech::all();

        // 4. Ambil Data Experience (Urutkan dari yang terbaru)
        $experiences = Journey::orderBy('id', 'desc')->get();

        // 5. Ambil Project (Batasi 4 saja untuk halaman depan)
        $projects = Project::latest()->take(4)->get();

        // 6. Ambil Sertifikat (Batasi 6 saja)
        $certificates = Certificate::latest()->get();

        // 7. Siapkan data Competencies (diambil dari kolom JSON 'core' di table about)
        // Jika $about kosong, beri array kosong agar tidak error
        $competencies = $about ? $about->core : [];

        return view('home', compact(
            'profile',
            'about',
            'techs',
            'experiences',
            'projects',
            'certificates',
            'competencies'
        ));
    }

    public function sendContact(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // 2. Konfigurasi Telegram (Sesuaikan dengan Token Anda)
        $botToken = "7544590388:AAHOyr9i0MSeEEdz8glb_Vy7y7IC-hYNgw4";
        $chatId = "7060854128";

        $text = "📩 *New Contact Message*\n\n" .
            "👤 *Name:* " . $request->name . "\n" .
            "📧 *Email:* " . $request->email . "\n" .
            "💬 *Message:* \n" . $request->message;

        // 3. Kirim via Laravel HTTP Client (Lebih aman dari file_get_contents)
        try {
            Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown'
            ]);

            return redirect()->back()->with('success', 'Message sent successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send message. Please try again.');
        }
    }

}
