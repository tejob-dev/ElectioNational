<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OperateurSuivi;
use App\Http\Requests\OperateurSuiviStoreRequest;
use App\Http\Requests\OperateurSuiviUpdateRequest;

class OperateurSuiviController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', OperateurSuivi::class);

        $search = $request->get('search', '');

        $operateurSuivis = OperateurSuivi::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.operateur_suivis.index',
            compact('operateurSuivis', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', OperateurSuivi::class);

        return view('app.operateur_suivis.create');
    }

    /**
     * @param \App\Http\Requests\OperateurSuiviStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OperateurSuiviStoreRequest $request)
    {
        $this->authorize('create', OperateurSuivi::class);

        $validated = $request->validated();

        $operateurSuivi = OperateurSuivi::create($validated);

        return redirect()
            ->route('operateur-suivis.edit', $operateurSuivi)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OperateurSuivi $operateurSuivi
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OperateurSuivi $operateurSuivi)
    {
        $this->authorize('view', $operateurSuivi);

        return view('app.operateur_suivis.show', compact('operateurSuivi'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OperateurSuivi $operateurSuivi
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, OperateurSuivi $operateurSuivi)
    {
        $this->authorize('update', $operateurSuivi);

        return view('app.operateur_suivis.edit', compact('operateurSuivi'));
    }

    /**
     * @param \App\Http\Requests\OperateurSuiviUpdateRequest $request
     * @param \App\Models\OperateurSuivi $operateurSuivi
     * @return \Illuminate\Http\Response
     */
    public function update(
        OperateurSuiviUpdateRequest $request,
        OperateurSuivi $operateurSuivi
    ) {
        $this->authorize('update', $operateurSuivi);

        $validated = $request->validated();

        $operateurSuivi->update($validated);

        return redirect()
            ->route('operateur-suivis.edit', $operateurSuivi)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OperateurSuivi $operateurSuivi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OperateurSuivi $operateurSuivi)
    {
        $this->authorize('delete', $operateurSuivi);

        $operateurSuivi->delete();

        return redirect()
            ->route('operateur-suivis.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
