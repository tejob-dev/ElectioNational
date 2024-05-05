<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\RCommune;
use Illuminate\Http\Request;
use App\Http\Requests\RCommuneStoreRequest;
use App\Http\Requests\RCommuneUpdateRequest;

class RCommuneController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', RCommune::class);

        $search = $request->get('search', '');

        
        $rcommunes = RCommune::search($search)
        ->userlimit()
            ->latest()
            ->paginate(12)
            ->withQueryString();
        // dd($rcommunes);

        return view('app.rcommunes.index', compact('rcommunes', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', RCommune::class);

        $sections = Section::userlimit()->pluck('libel', 'id');

        return view('app.rcommunes.create', compact('sections'));
    }

    /**
     * @param \App\Http\Requests\RCommuneStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RCommuneStoreRequest $request)
    {
        $this->authorize('create', RCommune::class);

        $validated = $request->validated();

        $RCommune = RCommune::create($validated);

        return redirect()
            ->route('rcommunes.edit', $rcommune)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RCommune $rcommune
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RCommune $rcommune)
    {
        $this->authorize('view', $rcommune);

        return view('app.rcommunes.show', compact('rcommune'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RCommune $rcommune
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, RCommune $rcommune)
    {
        $this->authorize('update', $rcommune);

        $sections = Section::userlimit()->pluck('libel', 'id');

        return view('app.rcommunes.edit', compact('rcommune', 'sections'));
    }

    /**
     * @param \App\Http\Requests\RCommuneUpdateRequest $request
     * @param \App\Models\RCommune $rcommune
     * @return \Illuminate\Http\Response
     */
    public function update(RCommuneUpdateRequest $request, RCommune $rcommune)
    {
        $this->authorize('update', $rcommune);

        $validated = $request->validated();

        $rcommune->update($validated);

        return redirect()
            ->route('rcommunes.edit', $rcommune)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RCommune $rcommune
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RCommune $rcommune)
    {
        $this->authorize('delete', $rcommune);

        $rcommune->delete();

        return redirect()
            ->route('rcommunes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
