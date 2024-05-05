<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\SousSection;
use App\Models\LieuVote;
use App\Models\AgentTerrain;
use Illuminate\Http\Request;
use App\Http\Requests\AgentTerrainStoreRequest;
use App\Http\Requests\AgentTerrainUpdateRequest;
use DataTables;
use Illuminate\Support\Facades\Auth;

class AgentTerrainController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', AgentTerrain::class);

        $search = $request->get('search', '');

        $agentTerrains = AgentTerrain::search($search)
            ->userlimit()
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view(
            'app.agent_terrains.index',
            compact('agentTerrains', 'search')
        );
    }
    
    public function getAgentList(Request $request, $single){
        
        $del = '<form action="/agent-terrains/';
        $token = csrf_token();
        $del2 = '" method="POST" onsubmit="return confirm(\'Voulez-vous vraiment supprimé?\')"><input type="hidden" name="_token" value="'.$token.'"> <input type="hidden" name="_method" value="DELETE"> <button type="submit" class="button"><i class="icon ion-md-trash text-red-600"></i></button></form>';
        
        $usercr = Auth::user();
        
        if ($request->ajax()) {
            
            $agents = AgentTerrain::userlimit()->with('section', 'sousSection')->latest()->get();
    
            return DataTables::of($agents)
                ->addColumn('section', function ($agent) {
                    return optional($agent->section)->libel ?? '-';
                })
                ->addColumn('soussection', function ($agent) {
                    return optional($agent->sousSection)->libel ?? '-';
                })
                ->addColumn('action', function($row) use($del, $del2, $single, $agents, $usercr){
                    $data = $agents;
                    $itemId = print_r($row[0]);
                    $ids = $data[$itemId-1]->id;
                    $itemId = $ids;
                    if($single == 0){
                        $actionBtn = '';
                        //if($usercr->can('update', AgentTerrain::class))
                        $actionBtn .= '<a href="/agent-terrains/'.$row->id.'/edit"><button type="button" class="button"><i class="icon ion-md-create"></i></button></a>';
                        //if($usercr->can('view', AgentTerrain::class))
                        $actionBtn .= '<a href="/agent-terrains/'.$row->id.'"><button type="button" class="button"><i class="icon ion-md-eye"></i></button></a>';
                        //if($usercr->can('delete', AgentTerrain::class))
                        $actionBtn .= $del.$row->id.$del2;
                    }else $actionBtn = "";
                    return $actionBtn;
                })
                ->rawColumns(['section', 'soussection', 'action'])
                ->make(true);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', AgentTerrain::class);

        $sections = Section::pluck('libel', 'id');
        
        $soussections = SousSection::pluck("libel","id");

        return view('app.agent_terrains.create', compact('sections', 'soussections'));
    }

    /**
     * @param \App\Http\Requests\AgentTerrainStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentTerrainStoreRequest $request)
    {
        $this->authorize('create', AgentTerrain::class);

        $validated = $request->validated();

        $agentTerrain = AgentTerrain::create($validated);

        return redirect()
            ->route('agent-terrains.edit', $agentTerrain)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentTerrain $agentTerrain
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AgentTerrain $agentTerrain)
    {
        $this->authorize('view', $agentTerrain);

        return view('app.agent_terrains.show', compact('agentTerrain'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentTerrain $agentTerrain
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, AgentTerrain $agentTerrain)
    {
        $this->authorize('update', $agentTerrain);

        $sections = Section::pluck('libel', 'id');
        
        $soussections = SousSection::pluck("libel","id");

        return view(
            'app.agent_terrains.edit',
            compact('agentTerrain', 'sections', 'soussections')
        );
    }

    /**
     * @param \App\Http\Requests\AgentTerrainUpdateRequest $request
     * @param \App\Models\AgentTerrain $agentTerrain
     * @return \Illuminate\Http\Response
     */
    public function update(
        AgentTerrainUpdateRequest $request,
        AgentTerrain $agentTerrain
    ) {
        $this->authorize('update', $agentTerrain);

        $validated = $request->validated();

        $agentTerrain->update($validated);

        return redirect()
            ->route('agent-terrains.edit', $agentTerrain)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AgentTerrain $agentTerrain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AgentTerrain $agentTerrain)
    {
        $this->authorize('delete', $agentTerrain);

        $agentTerrain->delete();

        return redirect()
            ->route('agent-terrains.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
