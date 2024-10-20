<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Models\Domain;
use App\Repositories\DomainRepository;
use App\Services\DomainService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function __construct(
        private DomainRepository $domainRepository,
        private DomainService $domainService
    ) {}

    public function index(): Response
    {
        $authenticatedUserId = Auth::id();
        
        return Inertia::render('Domains/Index', [
            'domains' => $this->domainRepository->getDomainsForUser($authenticatedUserId),
            'userId' => $authenticatedUserId,
        ]);
    }

    public function store(StoreDomainRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->domainRepository->create($validated);

        return redirect()->back()->with('success', 'Domain added successfully');
    }

    public function destroy(Domain $domain): RedirectResponse
    {
        $this->authorize('delete', $domain);

        $this->domainRepository->delete($domain);

        return redirect()->back();
    }
}
