<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Models\LieuVote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AlerteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $alertes = Alerte::search($search)->latest()
        ->paginate(12)
        ->withQueryString();
        return view("app.alertes.index", compact("alertes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->text){
            //ALT*LV-02*Koffi Mark*025245225*Mon message
            $arrCont = explode("*", $request->text);
            $alts = Alerte::create([
                "lieuvote" => optional(LieuVote::where("code", "like", "%".$arrCont[1]."%")->first())->libel??"Non trouvé",
                "supervise" => $arrCont[2]??"Non trouvé",
                "phone" => $arrCont[3]??"Non trouvé",
                "message" => null,
                "viewers" => null,
                "responsable" => null,
            ]);

            return response()->json(["succes"=>true, "posted"=>$alts->id]);
        }

        return response()->json([]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alerte  $alerte
     * @return \Illuminate\Http\Response
     */
    public function show(Alerte $alerte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alerte  $alerte
     * @return \Illuminate\Http\Response
     */
    public function edit($alerte)
    {
        $alert = Alerte::find($alerte);
        return view('app.alertes.edit', compact('alert'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alerte  $alerte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $alerte)
    {
        $user = Auth::user();
        $alert = Alerte::find($alerte);
        $alts = $alert->update([
            "viewers" => 'okay',
            "message" => $user->name.' '.$user->prenom,
            "responsable" => $request->responsable,
        ]);

        return redirect()->route("alerte.agentlist.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alerte  $alerte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alerte $alerte)
    {
        //
    }
}
