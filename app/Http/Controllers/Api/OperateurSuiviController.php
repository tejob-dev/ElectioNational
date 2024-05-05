<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\OperateurSuivi;
use App\Http\Controllers\Controller;
use App\Http\Resources\OperateurSuiviResource;
use App\Http\Resources\OperateurSuiviCollection;
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
            ->paginate();

        return new OperateurSuiviCollection($operateurSuivis);
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

        return new OperateurSuiviResource($operateurSuivi);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OperateurSuivi $operateurSuivi
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OperateurSuivi $operateurSuivi)
    {
        $this->authorize('view', $operateurSuivi);

        return new OperateurSuiviResource($operateurSuivi);
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

        return new OperateurSuiviResource($operateurSuivi);
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

        return response()->noContent();
    }
}
