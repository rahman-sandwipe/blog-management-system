<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SessionAuthenticate;

class HomeController extends Controller
{
    public function homePage(Request $request)
    {
        $query = Post::query();

        if (SessionAuthenticate::class) {
            $query->where('visibility', 'public');
        }

        $posts = $query->latest()->get();

        return Inertia::render('HomePage', [
            'posts' => $posts
        ]);
    }
}
