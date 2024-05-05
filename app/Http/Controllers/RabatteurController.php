<?php

namespace App\Http\Controllers;

use App\Models\Rabatteur;
use Illuminate\Http\Request;
use App\Http\Requests\RabatteurStoreRequest;
use App\Http\Requests\RabatteurUpdateRequest;
use App\Models\LieuVote;

class RabatteurController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Rabatteur::class);

        $search = $request->get('search', '');

        $rabatteurs = Rabatteur::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.rabatteurs.index', compact('rabatteurs', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Rabatteur::class);

        return view('app.rabatteurs.create');
    }

    /**
     * @param \App\Http\Requests\RabatteurStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RabatteurStoreRequesat $request)
    {
        $this->authorize('create', Rabatteur::class);

        $validated = $request->validated();

        $rabatteur = Rabatteur::create($validated);

        return redirect()
            ->route('rabatteurs.edit', $rabatteur)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rabatteur $rabatteur
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Rabatteur $rabatteur)
    {
        $this->authorize('view', $rabatteur);

        return view('app.rabatteurs.show', compact('rabatteur'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rabatteur $rabatteur
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Rabatteur $rabatteur)
    {
        $this->authorize('update', $rabatteur);

        return view('app.rabatteurs.edit', compact('rabatteur'));
    }

    public function showImportRabat(){
        return view('app.rabatteurs.form-inputs-csv');
    }
    
    public function importRabat(Request $request){

        if ($request->hasFile('csv_file') && $request->file('csv_file')->isValid()) {
            // Get the uploaded file
            $uploadedFile = $request->file('csv_file');

            // Specify the delimiter used in the CSV file
            $delimiter = ';';
            $content = "";
            
            // Open the file for reading
            if (($handle = fopen($uploadedFile->path(), 'r')) !== false) {
                // Loop through each line in the CSV file
                while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {

                    if(sizeof($data) != 3) break;
                    $column1Value = $data[0];
                    $column2Value = $data[1];
                    $column3Value = $data[2];

//                    $content .= "Column 1: " . $column1Value . ", Column 2: " . $column2Value . ", Column 3: " . $column3Value . "\n";
                    $lieuv = LieuVote::where('libel', 'like', '%'.$column3Value.'%')->first();
                    if($lieuv){
                        $nameParts = explode(' ', $column1Value);
                        $name = $nameParts[0];
                        $prename = implode(' ', array_slice($nameParts, 1));
                        
                        $oldrabat = Rabatteur::where([['nom', 'like', '%'.$name.'%'],['prenoms', 'like', '%'.$prename.'%']])->first();
                        if($oldrabat){
                            $oldrabat->lieuVotes()->syncWithoutDetaching($lieuv);
                        }else{
                            $nrabat = Rabatteur::create([
                                'nom'=>$name,
                                'prenoms'=>$prename,
                                'telephone'=>$column2Value,
                            ]);
    
                            if($nrabat){
                                $nrabat->lieuVotes()->syncWithoutDetaching($lieuv);
                            }
                        }
                    }
                }

                // Close the file handle
                fclose($handle);
            } else {
                echo "Error opening the CSV file.";
            }
        } else {
            echo "Error uploading the CSV file.";
        }

        return redirect()->route('rabatteurs.index')->withSuccess(__('crud.common.saved'));

    }

    /**
     * @param \App\Http\Requests\RabatteurUpdateRequest $request
     * @param \App\Models\Rabatteur $rabatteur
     * @return \Illuminate\Http\Response
     */
    public function update(
        RabatteurUpdateRequest $request,
        Rabatteur $rabatteur
    ) {
        $this->authorize('update', $rabatteur);

        $validated = $request->validated();

        $rabatteur->update($validated);

        return redirect()
            ->route('rabatteurs.edit', $rabatteur)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rabatteur $rabatteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Rabatteur $rabatteur)
    {
        $this->authorize('delete', $rabatteur);

        $rabatteur->delete();

        return redirect()
            ->route('rabatteurs.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
