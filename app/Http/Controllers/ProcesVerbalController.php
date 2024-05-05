<?php

namespace App\Http\Controllers;

use App\Models\BureauVote;
use App\Models\ProcesVerbal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProcesVerbalStoreRequest;
use App\Http\Requests\ProcesVerbalUpdateRequest;

class ProcesVerbalController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ProcesVerbal::class);

        $search = $request->get('search', '');

        $procesVerbals = ProcesVerbal::search($search)
            ->userlimit()
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view(
            'app.proces_verbals.index',
            compact('procesVerbals', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ProcesVerbal::class);

        $bureauVotes = BureauVote::userlimit()->pluck('libel', 'id');

        return view('app.proces_verbals.create', compact('bureauVotes'));
    }

    /**
     * @param \App\Http\Requests\ProcesVerbalStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcesVerbalStoreRequest $request)
    {
        $this->authorize('create', ProcesVerbal::class);
        $validated = $request->validated();
        //dd($validated);
        if ($request->hasFile('photo')) {
            $publicPrecverbPath = storage_path('app/public/pvs');
            //dd($publicPrecverbPath);
            if (!File::exists($publicPrecverbPath)) {
                File::makeDirectory($publicPrecverbPath);
            }
            $filephoto = $request->file('photo');
            //dd(); 
            $validated['photo'] = $filephoto->store('pvs','public');
        }
        
        $bv = BureauVote::find($validated['bureau_vote_id']);
        
        foreach ($bv->procesVerbals as $pvsave){
            $pvsave->delete();            
        }
        $procesVerbal = ProcesVerbal::create($validated);


        //$publicImageUrl = asset('storage/' . $validated['photo']);

        return redirect()
            ->route('proces-verbals.edit', $procesVerbal)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProcesVerbal $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ProcesVerbal $procesVerbal)
    {
        $this->authorize('view', $procesVerbal);

        return view('app.proces_verbals.show', compact('procesVerbal'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProcesVerbal $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ProcesVerbal $procesVerbal)
    {
        $this->authorize('update', $procesVerbal);

        $bureauVotes = BureauVote::userlimit()->pluck('libel', 'id');

        return view(
            'app.proces_verbals.edit',
            compact('procesVerbal', 'bureauVotes')
        );
    }

    /**
     * @param \App\Http\Requests\ProcesVerbalUpdateRequest $request
     * @param \App\Models\ProcesVerbal $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function update(
        ProcesVerbalUpdateRequest $request,
        ProcesVerbal $procesVerbal
    ) {
        $this->authorize('update', $procesVerbal);

        $validated = $request->validated();
        if ($request->hasFile('photo')) {
            if ($procesVerbal->photo) {
                Storage::delete($procesVerbal->photo);
            }

            $validated['photo'] = $request->file('photo')->store('public');
        }

        $procesVerbal->update($validated);

        return redirect()
            ->route('proces-verbals.edit', $procesVerbal)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProcesVerbal $procesVerbal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProcesVerbal $procesVerbal)
    {
        $this->authorize('delete', $procesVerbal);

        if ($procesVerbal->photo) {
            Storage::delete($procesVerbal->photo);
        }

        $procesVerbal->delete();

        return redirect()
            ->route('proces-verbals.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
