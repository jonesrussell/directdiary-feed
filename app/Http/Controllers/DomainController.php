<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class DomainController extends Controller
{
    public function index(): Response
    {
        /** @var User $user */
        $user = auth()->user();
        $domains = $user->domains()->latest()->get();

        return Inertia::render('Domains/Index', [
            'domains' => $domains
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:domains',
                'regex:/^(?!-)[A-Za-z0-9-]{1,63}(?<!-)(\.[A-Za-z]{2,63})+$/',
            ],
        ]);

        /** @var User $user */
        $user = auth()->user();

        $parts = explode('.', $validated['name']);
        $tld = Str::lower(array_pop($parts));
        $name = implode('.', $parts);

        $validTlds = array_keys(top_level_domains());
        if (!in_array($tld, $validTlds)) {
            return Redirect::back()->withErrors(['name' => 'Invalid top-level domain.']);
        }

        $user->domains()->create([
            'name' => $name,
            'extension' => $tld,
        ]);

        return Redirect::back()->with('success', 'Domain added successfully.');
    }

    public function destroy(Domain $domain): RedirectResponse
    {
        $this->authorize('delete', $domain);

        $domain->delete();

        return redirect()->back();

        // return Redirect::route('domains.index')
        //     ->with('success', 'Domain deleted successfully.');
    }
}
