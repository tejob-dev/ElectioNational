<?php

namespace App\Http\Controllers;

use App\Models\Parrain;

use App\Models\LieuVote;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\ParrainStoreRequest;
use App\Http\Requests\ParrainUpdateRequest;

use Illuminate\Support\Facades\DB;

class ParrainController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Parrain::class);

        $search = $request->get('search', '');

        $parrains = Parrain::search($search)
            ->userlimit()
            ->orderBy("id", "desc")
            ->paginate(12)
            ->withQueryString();

        return view('app.parrains.index', compact('parrains', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Parrain::class);

        return view('app.parrains.create');
    }

    /**
     * @param \App\Http\Requests\ParrainStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParrainStoreRequest $request)
    {
        $this->authorize('create', Parrain::class);

        $validated = $request->validated();

        $parrain = Parrain::create($validated);

        return redirect()
            ->route('parrains.edit', $parrain)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parrain $parrain
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Parrain $parrain)
    {
        $this->authorize('view', $parrain);

        return view('app.parrains.show', compact('parrain'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parrain $parrain
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Parrain $parrain)
    {
        $this->authorize('update', $parrain);

        return view('app.parrains.edit', compact('parrain'));
    }

    /**
     * @param \App\Http\Requests\ParrainUpdateRequest $request
     * @param \App\Models\Parrain $parrain
     * @return \Illuminate\Http\Response
     */
    public function update(ParrainUpdateRequest $request, Parrain $parrain)
    {
        $this->authorize('update', $parrain);

        $validated = $request->validated();

        $parrain->update($validated);

        return redirect()
            ->route('parrains.edit', $parrain)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parrain $parrain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Parrain $parrain)
    {
        $this->authorize('delete', $parrain);
        $idd = $parrain->id;
        //dd($idd);
        $parrain->delete();
        
        $this->updateAutoIncrementValue("parrains", $idd);
        

        return redirect()
            ->route('parrains.index')
            ->withSuccess(__('crud.common.removed'));
    }
    
    public function updateAutoIncrementValue($table, $newLastId)
    {
        // Disable foreign key checks to avoid potential issues
        if(Parrain::count() > 0){
            $idd = Parrain::all()->last()->id;
            if($idd === $newLastId){
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
                // Update the auto-increment value for the table
                DB::statement("ALTER TABLE $table AUTO_INCREMENT = $newLastId");
            
                // Enable foreign key checks
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            }
        }
    }

    public function exportParrainsOnly(Request $request){

        $parrains = Parrain::userlimit()->orWhereIn('id', explode(",", $request->ids) )->get();
        
        //dd($parrains);
    
        if(empty($parrains) == true) return redirect()->back();
        // these are the headers for the csv file. Not required but good to have one incase of system didn't recongize it properly
        $headers = array(
          'Content-Type' => 'text/csv'
        );
    
        //I am storing the csv file in public >> files folder. So that why I am creating files folder
        if (!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files", 0755, true, true);
        }
        
        $titles = [
            "ID",
            "Agent",
            "Tel. Agent",
            "Recenseur",
            "Section",
            "Sous section",
            "Nom",
            "Prenom",
            "Date de naissance",
            "Liste électorale",
            "Nº Carte",
            "Téléphone",
            "Lieu De Vote",
            "Résidence",
            "Profession",
            "Observation",
            "Parrainé le",
            "Statut"
            ];
        
        $filename =  public_path("files/tous_exportes_".time().".csv");
        $handle = fopen($filename, 'w');
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        //adding the first row
        fputcsv($handle, $titles, ";");
    
        foreach($parrains as $data){
            if(optional($data->agentterrain)->section){
            
                $item = [
                    $data->id,
                    $data->nom_pren_par,
                    $data->telephone_par,
                    $data->recenser,
                    optional($data->agentterrain->section)->libel ?? "-",
                    optional($data->agentterrain->sousSection)->libel ?? "-",
                    $data->nom,
                    $data->prenom,
                    Carbon::createFromFormat('Y-m-d H:i:s', $data->date_naiss)->format('d/m/Y'),
                    $data->list_elect,
                    $data->cart_elect,
                    "225".$data->telephone,
                    $data->code_lv,
                    $data->residence,
                    $data->profession,
                    $data->observation,
                    $data->created_at ? Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d/m/Y')." à ".Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('H:i'): '-',
                    $data->status
                ];
                fputcsv($handle, $item, ";");
            }
        }
    
        fclose($handle);
        //download command
        return Response::download($filename, "les_parrains_".time().".csv", $headers);

    }
    
    public function exportParrains(){

        $parrains = Parrain::userlimit()->get();
    
        if(empty($parrains) == true) return redirect()->back();
        // these are the headers for the csv file. Not required but good to have one incase of system didn't recongize it properly
        $headers = array(
          'Content-Type' => 'text/csv'
        );
    
        //I am storing the csv file in public >> files folder. So that why I am creating files folder
        if (!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files", 0755, true, true);
        }
        
        $titles = [
            "ID",
            "Agent",
            "Tel. Agent",
            "Recenseur",
            "Section",
            "Sous section",
            "Nom",
            "Prenom",
            "Date de naissance",
            "Liste électorale",
            "Nº Carte",
            "Téléphone",
            "Lieu De Vote",
            "Résidence",
            "Profession",
            "Observation",
            "Parrainé le",
            "Statut"
            ];
        
        $filename =  public_path("files/tous_exportes_".time().".csv");
        $handle = fopen($filename, 'w');
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        //adding the first row
        fputcsv($handle, $titles, ";");
    
        foreach($parrains as $data){
            if(optional($data->agentterrain)->section){
            
                $item = [
                    $data->id,
                    $data->nom_pren_par,
                    $data->telephone_par,
                    $data->recenser,
                    optional($data->agentterrain->section)->libel ?? "-",
                    optional($data->agentterrain->sousSection)->libel ?? "-",
                    $data->nom,
                    $data->prenom,
                    Carbon::createFromFormat('Y-m-d H:i:s', $data->date_naiss)->format('d/m/Y'),
                    $data->list_elect,
                    $data->cart_elect,
                    "225".$data->telephone,
                    $data->code_lv,
                    $data->residence,
                    $data->profession,
                    $data->observation,
                    $data->created_at ? Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d/m/Y')." à ".Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('H:i'): '-',
                    $data->status
                ];
                fputcsv($handle, $item, ";");
            }
        }
    
        fclose($handle);
        //download command
        return Response::download($filename, "les_parrains_".time().".csv", $headers);

    }
}
