<?php

namespace App\Http\Controllers\Api;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AgentDeSectionResource;
use App\Http\Resources\AgentDeSectionCollection;

class SectionAgentDeSectionsController extends Controller
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

        $agentDeSections = $section
            ->agentDeSections()
            ->search($search)
            ->latest()
            ->paginate();

        return new AgentDeSectionCollection($agentDeSections);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Section $section)
    {
        $this->authorize('create', AgentDeSection::class);

        $validated = $request->validate([
            'nom' => ['required', 'max:255', 'string'],
            'prenom' => ['required', 'max:255', 'string'],
            'telephone' => ['required', 'max:255', 'string'],
        ]);

        $agentDeSection = $section->agentDeSections()->create($validated);

        return new AgentDeSectionResource($agentDeSection);
    }
}
