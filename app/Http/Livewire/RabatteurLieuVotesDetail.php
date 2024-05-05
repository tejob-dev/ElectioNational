<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LieuVote;
use App\Models\Rabatteur;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RabatteurLieuVotesDetail extends Component
{
    use AuthorizesRequests;

    public Rabatteur $rabatteur;
    public LieuVote $lieuVote;
    public $lieuVotesForSelect = [];
    public $lieu_vote_id = null;

    public $showingModal = false;
    public $modalTitle = 'Ajouter un lieu de vote';

    protected $rules = [
        'lieu_vote_id' => ['required', 'exists:lieu_votes,id'],
    ];

    public function mount(Rabatteur $rabatteur)
    {
        $this->rabatteur = $rabatteur;
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
        $this->modalTitle = trans('crud.rabatteur_lieu_votes.new_title');
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

        $this->rabatteur->lieuVotes()->attach($this->lieu_vote_id, []);

        $this->hideModal();
    }

    public function detach($lieuVote)
    {
        $this->authorize('delete-any', LieuVote::class);

        $this->rabatteur->lieuVotes()->detach($lieuVote);

        $this->resetLieuVoteData();
    }

    public function render()
    {
        return view('livewire.rabatteur-lieu-votes-detail', [
            'rabatteurLieuVotes' => $this->rabatteur
                ->lieuVotes()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
