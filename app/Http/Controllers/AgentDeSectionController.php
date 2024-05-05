<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\AgentDeSection;
use App\Http\Requests\AgentDeSectionStoreRequest;
use App\Http\Requests\AgentDeSectionUpdateRequest;

class AgentDeSectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', AgentDeSection::class);

        $search = $request->get('search', '');

        $agentDeSections = AgentDeSection::search($search)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view(
            'app.agent_de_sections.index',
            compact('agentDeSections', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', AgentDeSection::class);

        $sections = Section::pluck('libel', 'id');

        return view('app.agent_de_sections.create', compact('sections'));
    }

    /**
     * @param \App\Http\Requests\AgentDeSectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentDeSectionStoreRequest $request)
    {
        $this->authorize('create', AgentDeSection::class);

        $validated = $request->validated();

        $agentDeSection = AgentDeSection::create($validated);

        return redirect()
            ->route('agent-de-sections.edit', $agentDeSection)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentDeSection $agentDeSection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AgentDeSection $agentDeSection)
    {
        $this->authorize('view', $agentDeSection);

        return view('app.agent_de_sections.show', compact('agentDeSection'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentDeSection $agentDeSection
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, AgentDeSection $agentDeSection)
    {
        $this->authorize('update', $agentDeSection);

        $sections = Section::pluck('libel', 'id');

        return view(
            'app.agent_de_sections.edit',
            compact('agentDeSection', 'sections')
        );
    }

    /**
     * @param \App\Http\Requests\AgentDeSectionUpdateRequest $request
     * @param \App\Models\AgentDeSection $agentDeSection
     * @return \Illuminate\Http\Response
     */
    public function update(
        AgentDeSectionUpdateRequest $request,
        AgentDeSection $agentDeSection
    ) {
        $this->authorize('update', $agentDeSection);

        $validated = $request->validated();

        $agentDeSection->update($validated);

        return redirect()
            ->route('agent-de-sections.edit', $agentDeSection)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentDeSection $agentDeSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AgentDeSection $agentDeSection)
    {
        $this->authorize('delete', $agentDeSection);

        $agentDeSection->delete();

        return redirect()
            ->route('agent-de-sections.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
