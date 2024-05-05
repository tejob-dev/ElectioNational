<?php

namespace App\Http\Controllers;

use App\Models\SousSection;
use Illuminate\Http\Request;
use App\Http\Requests\SousSectionStoreRequest;
use App\Http\Requests\SousSectionUpdateRequest;

class SousSectionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SousSection::class);

        $search = $request->get('search', '');

        $sousSections = SousSection::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.sous_sections.index',
            compact('sousSections', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', SousSection::class);

        return view('app.sous_sections.create');
    }

    /**
     * @param \App\Http\Requests\SousSectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SousSectionStoreRequest $request)
    {
        $this->authorize('create', SousSection::class);

        $validated = $request->validated();

        $sousSection = SousSection::create($validated);

        return redirect()
            ->route('sous-sections.edit', $sousSection)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SousSection $sousSection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SousSection $sousSection)
    {
        $this->authorize('view', $sousSection);

        return view('app.sous_sections.show', compact('sousSection'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SousSection $sousSection
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SousSection $sousSection)
    {
        $this->authorize('update', $sousSection);

        return view('app.sous_sections.edit', compact('sousSection'));
    }

    /**
     * @param \App\Http\Requests\SousSectionUpdateRequest $request
     * @param \App\Models\SousSection $sousSection
     * @return \Illuminate\Http\Response
     */
    public function update(
        SousSectionUpdateRequest $request,
        SousSection $sousSection
    ) {
        $this->authorize('update', $sousSection);

        $validated = $request->validated();

        $sousSection->update($validated);

        return redirect()
            ->route('sous-sections.edit', $sousSection)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SousSection $sousSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SousSection $sousSection)
    {
        $this->authorize('delete', $sousSection);

        $sousSection->delete();

        return redirect()
            ->route('sous-sections.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
