<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Quartier;
use Illuminate\Http\Request;
use App\Http\Requests\QuartierStoreRequest;
use App\Http\Requests\QuartierUpdateRequest;

class QuartierController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Quartier::class);

        $search = $request->get('search', '');

        $quartiers = Quartier::search($search)
            ->userlimit()
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('app.quartiers.index', compact('quartiers', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Quartier::class);

        $sections = Section::userlimit()->pluck('libel', 'id');

        return view('app.quartiers.create', compact('sections'));
    }

    /**
     * @param \App\Http\Requests\QuartierStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuartierStoreRequest $request)
    {
        $this->authorize('create', Quartier::class);

        $validated = $request->validated();

        $quartier = Quartier::create($validated);

        return redirect()
            ->route('quartiers.edit', $quartier)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quartier $quartier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Quartier $quartier)
    {
        $this->authorize('view', $quartier);

        return view('app.quartiers.show', compact('quartier'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quartier $quartier
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Quartier $quartier)
    {
        $this->authorize('update', $quartier);

        $sections = Section::userlimit()->pluck('libel', 'id');

        return view('app.quartiers.edit', compact('quartier', 'sections'));
    }

    /**
     * @param \App\Http\Requests\QuartierUpdateRequest $request
     * @param \App\Models\Quartier $quartier
     * @return \Illuminate\Http\Response
     */
    public function update(QuartierUpdateRequest $request, Quartier $quartier)
    {
        $this->authorize('update', $quartier);

        $validated = $request->validated();

        $quartier->update($validated);

        return redirect()
            ->route('quartiers.edit', $quartier)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quartier $quartier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Quartier $quartier)
    {
        $this->authorize('delete', $quartier);

        $quartier->delete();

        return redirect()
            ->route('quartiers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
