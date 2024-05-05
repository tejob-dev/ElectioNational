<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LieuVote;
use App\Models\OperateurSuivi;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OperateurSuiviLieuVotesDetail extends Component
{
    use AuthorizesRequests;

    public OperateurSuivi $operateurSuivi;
    public LieuVote $lieuVote;
    public $lieuVotesForSelect = [];
    public $lieu_vote_id = null;

    public $showingModal = false;
    public $modalTitle = 'Ajouter un lieu de vote';

    protected $rules = [
        'lieu_vote_id' => ['required', 'exists:lieu_votes,id'],
    ];

    public function mount(OperateurSuivi $operateurSuivi)
    {
        $this->operateurSuivi = $operateurSuivi;
        $this->lieuVotesForSelect = LieuVote::pluck('libel', 'id');
        $this->resetLieuVoteData();
    }

    public function resetLieuVoteData()
    {
        $this->lieuVote = new LieuVote();

        $this->lieu_vote_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newLieuVote()
    {
        $this->modalTitle = trans('crud.operateur_suivi_lieu_votes.new_title');
        $this->resetLieuVoteData();

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        $this->authorize('create', LieuVote::class);

        $this->operateurSuivi->lieuVotes()->attach($this->lieu_vote_id, []);

        $this->hideModal();
    }

    public function detach($lieuVote)
    {
        $this->authorize('delete-any', LieuVote::class);

        $this->operateurSuivi->lieuVotes()->detach($lieuVote);

        $this->resetLieuVoteData();
    }

    public function render()
    {
        return view('livewire.operateur-suivi-lieu-votes-detail', [
            'operateurSuiviLieuVotes' => $this->operateurSuivi
                ->lieuVotes()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
