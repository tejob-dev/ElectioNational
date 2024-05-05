<?php

namespace App\Http\Controllers\Api;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuartierResource;
use App\Http\Resources\QuartierCollection;

class SectionQuartiersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Section $section)
    {
        $this->authorize('view', $section);

        $search = $request->get('search', '');

        $quartiers = $section
            ->quartiers()
            ->search($search)
            ->latest()
            ->paginate();

        return new QuartierCollection($quartiers);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Section $section)
    {
        $this->authorize('create', Quartier::class);

        $validated = $request->validate([
            'libel' => ['required', 'max:255', 'string'],
            'nbrinscrit' => ['required', 'numeric'],
            'objectif' => ['required', 'numeric'],
            'seuil' => ['required', 'numeric'],
        ]);

        $quartier = $section->quartiers()->create($validated);

        return new QuartierResource($quartier);
    }
}
