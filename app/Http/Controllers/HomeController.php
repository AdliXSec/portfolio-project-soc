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
        // 1. Validasi Input dengan sanitasi
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Sanitasi input untuk mencegah injection
        $name = strip_tags(trim($validated['name']));
        $email = filter_var(trim($validated['email']), FILTER_SANITIZE_EMAIL);
        $message = strip_tags(trim($validated['message']));

        // 2. Ambil credentials dari environment (JANGAN hardcode!)
        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        // Jika tidak dikonfigurasi, skip pengiriman Telegram
        if (!$botToken || !$chatId) {
            \Log::warning('Telegram not configured. Contact message from: ' . $email);
            return redirect()->back()->with('success', 'Message received successfully!');
        }

        $text = "📩 *New Contact Message*\n\n" .
            "👤 *Name:* " . $name . "\n" .
            "📧 *Email:* " . $email . "\n" .
            "💬 *Message:* \n" . $message;

        // 3. Kirim via Laravel HTTP Client
        try {
            Http::timeout(10)->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown'
            ]);

            return redirect()->back()->with('success', 'Message sent successfully!');

        } catch (\Exception $e) {
            \Log::error('Telegram send failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send message. Please try again.');
        }
    }

}
