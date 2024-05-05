<?php

namespace App\Http\Controllers;

use App\Models\LieuVote;
use App\Models\BureauVote;
use Illuminate\Http\Request;
use App\Http\Requests\BureauVoteStoreRequest;
use App\Http\Requests\BureauVoteUpdateRequest;
use App\Models\Candidat;

class BureauVoteController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', BureauVote::class);

        $search = $request->get('search', '');

        if($search){
            $bureauVotes = BureauVote::with("lieuVote")
                ->whereHas("lieuvote", function($q) use($search){
                    $q->where('libel', 'like', "%".$search."%");
                })
                ->orWhere("libel", 'like', "%".$search."%")
                ->userlimit()
                ->latest()
                ->paginate(12)
                ->withQueryString();
        }else{
            $bureauVotes = BureauVote::search($search)
                ->userlimit()
                ->latest()
                ->paginate(12)
                ->withQueryString();
        }

        return view('app.bureau_votes.index', compact('bureauVotes', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', BureauVote::class);

        $lieuVotes = LieuVote::userlimit()->pluck('libel', 'id');

        return view('app.bureau_votes.create', compact('lieuVotes'));
    }

    /**
     * @param \App\Http\Requests\BureauVoteStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BureauVoteStoreRequest $request)
    {
        $this->authorize('create', BureauVote::class);

        $validated = $request->validated();

        $bureauVote = BureauVote::create($validated);

        return redirect()
            ->route('bureau-votes.edit', $bureauVote)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BureauVote $bureauVote
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BureauVote $bureauVote)
    {
        $this->authorize('view', $bureauVote);

        return view('app.bureau_votes.show', compact('bureauVote'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BureauVote $bureauVote
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, BureauVote $bureauVote)
    {
        $this->authorize('update', $bureauVote);

        $lieuVotes = LieuVote::userlimit()->pluck('libel', 'id');

        return view(
            'app.bureau_votes.edit',
            compact('bureauVote', 'lieuVotes')
        );
    }

    /**
     * @param \App\Http\Requests\BureauVoteUpdateRequest $request
     * @param \App\Models\BureauVote $bureauVote
     * @return \Illuminate\Http\Response
     */
    public function update(
        BureauVoteUpdateRequest $request,
        BureauVote $bureauVote
    ) {
        $this->authorize('update', $bureauVote);

        $validated = $request->validated();
        //dd(isset($request->votant_resul));
        if(isset($request->votant_resul)){
            $candNotes = [];
            $candi = Candidat::get();
            foreach($candi as $cand){
                $namek = $cand->code;
                if($namek){
                    $candNotes[$namek] = intval($request->$namek);
                }
            }
            $endData = json_encode($candNotes);
            //dd($endData);
            $bureauVote->update([
                "votant_resul"=>$request->votant_resul,
                "bult_nul"=>$request->bult_nul,
                "bult_blan"=>$request->bult_blan,
                "candidat_note"=>$endData,
            ]);
        }else $bureauVote->update($validated);

        return redirect()
            ->route('bureau-votes.edit', $bureauVote)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BureauVote $bureauVote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BureauVote $bureauVote)
    {
        $this->authorize('delete', $bureauVote);

        $bureauVote->delete();

        return redirect()
            ->route('bureau-votes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
