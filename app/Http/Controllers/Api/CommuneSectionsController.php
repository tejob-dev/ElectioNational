<?php

namespace App\Http\Controllers\Api;

use App\Models\Commune;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Http\Resources\SectionCollection;

class CommuneSectionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Commune $commune)
    {
        $this->authorize('view', $commune);

        $search = $request->get('search', '');

        $sections = $commune
            ->sections()
            ->search($search)
            ->latest()
            ->paginate();

        return new SectionCollection($sections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Commune $commune
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Commune $commune)
    {
        $this->authorize('create', Section::class);

        $validated = $request->validate([
            'libel' => ['required', 'max:255', 'string'],
            'nbrinscrit' => ['required', 'numeric'],
            'objectif' => ['required', 'numeric'],
            'seuil' => ['required', 'numeric'],
        ]);

        $section = $commune->sections()->create($validated);

        return new SectionResource($section);
    }
}
