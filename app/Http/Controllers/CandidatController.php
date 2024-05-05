<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CandidatStoreRequest;
use App\Http\Requests\CandidatUpdateRequest;

class CandidatController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Candidat::class);

        $search = $request->get('search', '');

        $candidats = Candidat::search($search)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('app.candidats.index', compact('candidats', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Candidat::class);

        return view('app.candidats.create');
    }

    /**
     * @param \App\Http\Requests\CandidatStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CandidatStoreRequest $request)
    {
        $this->authorize('create', Candidat::class);

        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $candidat = Candidat::create($validated);

        return redirect()
            ->route('candidats.edit', $candidat)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Candidat $candidat
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Candidat $candidat)
    {
        $this->authorize('view', $candidat);

        return view('app.candidats.show', compact('candidat'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Candidat $candidat
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Candidat $candidat)
    {
        $this->authorize('update', $candidat);

        return view('app.candidats.edit', compact('candidat'));
    }

    /**
     * @param \App\Http\Requests\CandidatUpdateRequest $request
     * @param \App\Models\Candidat $candidat
     * @return \Illuminate\Http\Response
     */
    public function update(CandidatUpdateRequest $request, Candidat $candidat)
    {
        $this->authorize('update', $candidat);

        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            if ($candidat->photo) {
                Storage::delete($candidat->photo);
            }

            $validated['photo'] = $request->file('photo')->store('public');
        }

        $candidat->update($validated);

        return redirect()
            ->route('candidats.edit', $candidat)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Candidat $candidat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Candidat $candidat)
    {
        $this->authorize('delete', $candidat);

        if ($candidat->photo) {
            Storage::delete($candidat->photo);
        }

        $candidat->delete();

        return redirect()
            ->route('candidats.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
