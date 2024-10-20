<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class LandingPageController extends Controller
{
    public function index(): Response
    {
        $landingPages = LandingPage::all();
        return Inertia::render('LandingPages/Index', [
            'landingPages' => $landingPages,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('LandingPages/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string|unique:landing_pages,domain',
        ]);

        LandingPage::create($validated);

        // TODO: Implement Kubernetes pod creation
        // TODO: Implement PowerDNS integration

        return Redirect::route('landing-pages.index')->with('status', 'landing-page-created');
    }

    public function show(LandingPage $landingPage): Response
    {
        return Inertia::render('LandingPages/Show', [
            'landingPage' => $landingPage,
        ]);
    }

    public function edit(LandingPage $landingPage): Response
    {
        return Inertia::render('LandingPages/Edit', [
            'landingPage' => $landingPage,
        ]);
    }

    public function update(Request $request, LandingPage $landingPage)
    {
        $validated = $request->validate([
            'domain' => 'required|string|unique:landing_pages,domain,' . $landingPage->id,
        ]);

        $landingPage->update($validated);

        return Redirect::route('landing-pages.index')->with('status', 'landing-page-updated');
    }

    public function destroy(LandingPage $landingPage)
    {
        $landingPage->delete();

        // TODO: Implement Kubernetes pod deletion
        // TODO: Implement PowerDNS record deletion

        return Redirect::route('landing-pages.index')->with('status', 'landing-page-deleted');
    }
}
