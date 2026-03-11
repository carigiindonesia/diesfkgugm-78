<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Document;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->get();
        $documents = Document::active()->get();
        $articles = Article::published()->take(3)->get();

        // Load all settings into an array
        $settingKeys = ['hero_logo', 'reg_simposium_url', 'reg_handson_url', 'reg_funrun_url', 'reg_pengmas_url', 'reg_pitch_url'];
        $settings = [];
        foreach ($settingKeys as $key) {
            $settings[$key] = Setting::get($key);
        }

        return view('pages.home', compact('sliders', 'documents', 'articles', 'settings'));
    }
}