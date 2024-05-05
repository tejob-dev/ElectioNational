<?php

namespace App\Http\Controllers;

use App\Models\AgentDuBureauVote;
use App\Models\OperateurSuivi;
use App\Models\LieuVote;
use App\Models\AgentMessage;
use App\Models\BureauVote;
use App\Models\Rabatteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $agentmessages = AgentMessage::search($search)
            ->where("from", "=", Auth::user()->id)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('app.message_agents.index', compact('agentmessages', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $lieuVotes = LieuVote::userlimit()->pluck('libel', 'id');
        $rabatteurs = Rabatteur::userlimit()->pluck('nom', 'id');
        $bureauVotes = BureauVote::userlimit()->pluck('libel', 'id');

        return view('app.message_agents.create', compact('lieuVotes','rabatteurs', 'bureauVotes', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'rabatteur_id'=>'string',
            'bureau_vote_id'=>'string',
            'lieu_vote_id'=>'string',
            'numberph'=>'nullable',
            'message'=>'required',
        ]);

        $nomOrNum = "";

        if($request->numberph){
            $listNum = explode(",", $validated['numberph']);
            $nomOrNum = "Numéro: ";
            foreach($listNum as $numm){
                $this->sendMessageToAg(["225"."$numm"], 'ERIC TABA',$validated['message']);
                $nomOrNum .= "$numm,";
            }
        }else{
            if($request->type == 0){
                /* $rabat = Rabatteur::find($validated['rabatteur_id']);
                $phone = $rabat->telephone;
                $this->sendMessageToAg(["225"."$phone"], 'ERIC TABA',$validated['message']);
                $nomOrNum = $rabat->nom.' '.$rabat->prenom; */
                $currLV = LieuVote::find($validated['lieu_vote_id']);
                $validated['lieuvote'] = $currLV->libel;
                $validated['from'] = Auth::user()->id;
                $rabats = $currLV->rabatteurs;
                $nomOrNum .= $currLV->libel.': ';
                foreach($rabats as $rabat){
                    //if($parrain->code_lv == $currLV->libel){
                    if($rabat->telephone){
                        //
                        $nomOrNum .= "$rabat->telephone, ";
                        
                        $this->sendMessageToAg(["$rabat->telephone"], 'ERIC TABA',$validated['message']);
                        //break;
                    }
                    //}
                }
            }elseif($request->type == 1){
                $currLV = LieuVote::find($validated['lieu_vote_id']);
                $validated['lieuvote'] = $currLV->libel;
                $validated['from'] = Auth::user()->id;
                $parrains = $currLV->operateurSuivis;
                $nomOrNum .= $currLV->libel.': ';
                foreach($parrains as $parrain){
                    //if($parrain->code_lv == $currLV->libel){
                    if($parrain->telephone){
                        //
                        $nomOrNum .= "$parrain->nom $parrain->prenoms, ";
                        $this->sendMessageToAg(["225"."$parrain->telephone"], 'ERIC TABA',$validated['message']);
                        //break;
                    }
                    //}
                }
            }elseif($request->type == 2){
                $rabat = BureauVote::find($validated['bureau_vote_id']);
                
                foreach ($rabat->agentDuBureauVotes as $agbv){
                    $phone = $agbv->telphone;
                    
                    $this->sendMessageToAg(["$phone"], 'ERIC TABA',$validated['message']);
                    $nomOrNum .= $rabat->nom.' '.$rabat->prenom.', ';
                }
            }
        }

        if(empty($nomOrNum)) return redirect()->back();
        
        $agent = AgentMessage::create([
            'lieuvote' => $nomOrNum,
            'message'=>$validated['message'],
            'from'=>Auth::user()->id
        ]);


        return redirect()
            ->route('agentmessages.index')
            ->withSuccess("Message envoyé aux agents avec succès !");
    }

    public function sendMessageToAg(array $numbers, string $sender, string $message){
        
        $new_date = date('Y-m-d H:i:s');
        $param = array(
            'username' => 'ELECTIO',
            'password' => '#@Electio2023@#',
            'sender' => "$sender",
            'text' => $message,
            'type' => 'text',
            'datetime' => $new_date,
        );
        $recipients = $numbers;//array('2250709202997','2250709202997','2250709202997');
        $post = 'to=' . implode(';', $recipients);
        foreach ($param as $key => $val) {
            $post .= '&' . $key . '=' . rawurlencode($val);
        }
        $url = "https://smsinter.net/api/api_http.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
        $result = curl_exec($ch);
        if(curl_errno($ch)) {
            $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
        } else {
            $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch($returnCode) {
                case 200 :
                    break;
                default :
                    $result = "HTTP ERROR: " . $returnCode;
            }
        }
        curl_close($ch);
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AgentMessage  $messageAgent
     * @return \Illuminate\Http\Response
     */
    public function show(AgentMessage $messageAgent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AgentMessage  $messageAgent
     * @return \Illuminate\Http\Response
     */
    public function edit(AgentMessage $messageAgent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgentMessage  $messageAgent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgentMessage $messageAgent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($agentmessage)
    {
        //dd($agentmessage);
        AgentMessage::find($agentmessage)->delete();


        return redirect()
            ->route('agentmessages.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
