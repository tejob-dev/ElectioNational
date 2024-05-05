<?php

namespace App\Http\Controllers\Api;

use App\Models\BureauVote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProcesVerbalResource;
use App\Http\Resources\ProcesVerbalCollection;

class BureauVoteProcesVerbalsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BureauVote $bureauVote
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BureauVote $bureauVote)
    {
        $this->authorize('view', $bureauVote);

        $search = $request->get('search', '');

        $procesVerbals = $bureauVote
            ->procesVerbals()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProcesVerbalCollection($procesVerbals);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BureauVote $bureauVote
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BureauVote $bureauVote)
    {
        $this->authorize('create', ProcesVerbal::class);

        $validated = $request->validate([
            'libel' => ['nullable', 'max:255', 'string'],
            'photo' => ['required', 'file'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('public');
        }

        $procesVerbal = $bureauVote->procesVerbals()->create($validated);

        return new ProcesVerbalResource($procesVerbal);
    }
}
