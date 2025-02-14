<?php

namespace App\Http\Controllers;

use App\Models\Page;

class SitemapController extends Controller
{
    public function generateSitemap()
    {
        // Récupère toutes les pages qui ne sont pas exclues du sitemap
        $pages = Page::where('sitemap_exclude', false)->get();

        // Retourne la vue du sitemap en format XML
        return response(view('sitemap', compact('pages')), 200)
            ->header('Content-Type', 'application/xml');
    }
}
