<?php

namespace App\Jobs;

use App\Models\Parrain;
use App\Models\AgentTerrain;
use App\Models\Commune;
use App\Models\ElectorParrain;
use App\Models\LieuVote;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessParrainSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->content = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $request = $this->request;
        $this->lauchProcForParrain($this->content);
    }

    public function writelog($content){
        $filename = date("Y-m-d")."_saver_pdci_response". ".txt"; // create filename based on current date
        $projectDir = base_path();
        $path = "$projectDir/".$filename;
        
        if (!file_exists($path)) { // check if file exists
          touch($path); // create the file if it doesn't exist
        }
        $file = fopen($path, "a");
        fwrite($file, $content."\n");
        fclose($file);
    }

    public function lauchProcForParrain($cont){
        $data = new \stdClass();
        $code = 404;
        $arrCont = explode("*", $cont);

        if(sizeof($arrCont) <= 6){

            // $timestampCr = strtotime($arrCont[1]);
            // $created_it = date("Y-m-d H:i:s", $timestampCr);
            // $created_it = Carbon::createFromFormat("d/m/Y H:i:s", str_replace("-", "/", $arrCont[1]))->toDateTimeString();
            // //dd($created_it);
            // $parrain = Parrain::where("created_at", $created_it)->first();
            
            // if($parrain){
            //     $data->success = true;
            //     $data->message = "Enrégistrement trouvé, mise à jour!";
            //     $data->error = "";
            //     $code = 200;

            //     $parrain->extrait = $arrCont[3];
            //     $parrain->observation = $arrCont[4];
            //     $parrain->recenser = $arrCont[5];
            //     $parrain->save();
            // }else{
            //     $data->success = true;
            //     $data->message = "Enrégistrement introuvale, non mise à jour!";
            //     $data->error = "";
            //     $code = 202;
            // }

            // $electorat = ElectorParrain::where("created_at", $created_it)->first();

            // if($electorat){
            //     $electorat->recenser = $arrCont[5];
            //     $electorat->save();
            // }

            // $data->code = $code;

            // $this->writelog(json_encode($data));
            return null;
        }

        $agTerrainPhone = $this->cleanPhone($arrCont[1]);
        $parrainPhone = $this->cleanPhone($arrCont[5]);
        $agTerrain = AgentTerrain::with("lieuVote")->where("telephone", $agTerrainPhone)->first();
        $agCommune = $agTerrain->commune;

        if(!$agTerrain) {

            $data->success = false;
            $data->error = "";
            $data->message = "Agent non reconnu!";
            $code = 202;

        }else{

            if(sizeof($arrCont) > 4){
                
                // $timestampCr = strtotime();
                // $timestampDateNaissCr = strtotime($arrCont[6]);
                // $dateNaiss = date("Y-m-d H:i:s", $timestampDateNaissCr);
                $date_obj = Carbon::createFromFormat('d/m/Y', str_replace("-", "/", $arrCont[4]));
                // $lieuvote = LieuVote::where("libel", "like", "%".$arrCont[9]."%")->first();
                $dateNaiss = $date_obj->format('Y-m-d H:i:s');
                $dateNaissElect = $date_obj->format('d/m/Y');
                // $created_it = Carbon::createFromFormat("d/m/Y H:i:s", str_replace("-", "/", $arrCont[1]))->toDateTimeString();
                //dd("Valide num ".$agTerrainPhone." ".$dateNaiss);
                Log::info(json_encode([
                    'nom' => removeAccentsAndUpperCase($arrCont[2]),
                    'prenom' => removeAccentsAndUpperCase($arrCont[3]),
                    'date_naiss' => str_replace("\\", "", $dateNaissElect),
                ]));
                //CHECK ON LIST ELECTOR
                $csvUrl = env('CSV_URL')??"http://127.0.0.1:5585";
                $response = Http::post("$csvUrl/check_elector", [
                    'nom' => removeAccentsAndUpperCase($arrCont[2]),
                    'prenom' => removeAccentsAndUpperCase($arrCont[3]),
                    'date_naiss' => str_replace("\\", "", $dateNaissElect),
                ]);
                
                $task_id = $response->json('task_id');
                $result_elector_exist = false;
                $lvname = "N/A";
                $result_cardelector = "N/A";
                if ($task_id) {
                    // Start checking the task status
                    list($lvname, $result_cardelector, $result_elector_exist) = $this->checkElectorStatus($task_id);
                }

                //END CHECK ON LIST ELECTOR

                
                $extrait = "";
                $observation = "";
                $agent_recences = "";
                if(array_key_exists(9, $arrCont)) $extrait = $arrCont[9]=="Y"?"Oui":"Non";
                $observation = "N/A"; //if(array_key_exists(14, $arrCont)) 
                if(array_key_exists(11, $arrCont)) $agent_recences = $arrCont[11];

                if($result_elector_exist){
                    //ADD PARRIN INFO IN ELECTOR LIST 2023
                    $curr_index = ElectorParrain::count() + 1;
                    // $lvget = LieuVote::where("code", "=", "$arrCont[9]")->first();
                    ElectorParrain::create([
                        'subid' => "E23_$curr_index",
                        'nom_prenoms' => strtoupper($arrCont[2])." ".ucwords($arrCont[3]),
                        'phone' => "$parrainPhone",
                        'date_naiss' => "$dateNaiss",
                        'lieu_naiss' => "N/A",
                        'profession' => "$arrCont[6]",
                        'genre' => "N/A",
                        'adress_physiq' => "N/A",
                        'adress_postal' => "N/A",
                        'carte_elect' => "$result_cardelector",
                        'nom_lv' => $lvname!=null?($lvname):"AUTRE CIRCONSCRIPTION",
                        'commune_id' => $agCommune?->id??null,
                        'agent_res_nompren' => "$agTerrain->nom $agTerrain->prenom",
                        'agent_res_phone' => "$agTerrainPhone",
                        'recenser' => "$agent_recences",
                        'elect_date' => "2023",
                        // 'created_at' => $created_it,
                        // 'updated_at' => $created_it,
                    ]);
                }


                $parrainCr = [
                    'nom_pren_par' => "$agTerrain->nom $agTerrain->prenom",
                    'telephone_par' => "$agTerrainPhone",
                    'recenser' => "$agent_recences",
                    'nom' => "$arrCont[2]",
                    'prenom' => "$arrCont[3]",
                    'list_elect' => $arrCont[7]=="Y"?"Oui":"Non",
                    'cni_dispo' => $arrCont[8]=="Y"?"Oui":"Non",
                    'is_milit' => $arrCont[10]=="M"?"Militant":"Sympathisant",
                    'extrait' => "$extrait",
                    'telephone' => "$parrainPhone",
                    'date_naiss' => "$dateNaiss",
                    // 'code_lv' => optional($arrCont[9])?"$arrCont[9]":"AUTRE CIRCONSCRIPTION",
                    'commune_id' => $agCommune?->id??null,
                    'residence' => "N/A",
                    'profession' => "$arrCont[6]",
                    'observation' => "$observation",
                    'status' => $result_elector_exist?"Ok":"Non traité",
                    // 'created_at' => $created_it,
                    // 'updated_at' => $created_it,
                ];
                //dd($parrainCr);
                $parrain = Parrain::create(
                    $parrainCr
                );

                $result = "No sms error message";
                if($parrain){
                    if($result_elector_exist){
                        $result = $this->sendMessage(array("225".$parrainPhone), 'ELECTIO', "Cher(e) ".strtoupper($arrCont[2])." ".ucwords($arrCont[3]).",\nTu figures sur la liste electorale de 2023.\nGardes un contact permanent avec ton Parrain ($agTerrainPhone).\n\nPDCI Digital");
                    }else{
                        $result = $this->sendMessage(array("225".$parrainPhone), 'ELECTIO', "Cher(e) ".strtoupper($arrCont[2])." ".ucwords($arrCont[3]).",\nTu ne figures pas sur la liste electorale de 2023.\nPour un accompagnement administratif, rapproches toi de ton Parrain ($agTerrainPhone).\n\nPDCI Digital");
                    }
                
                
                    if( !empty($result) ){
                        if(preg_match("/OK\:/i", $result)){
                            $data->success = true;
                            $data->message = "Recensement éffectué avec succès et message transmis";
                            $data->error = "";
                            $code = 200;
                        }else{
                            $data->success = false;
                            $data->error = $result;
                            $data->message = "Recensement éffectué avec succès et message non transmis";
                            $code = 202;
                        }
                    }else{
                        $data->success = false;
                        $data->error = $result;
                        $data->message = "Recensement éffectué avec succès et message non transmis";
                        $code = 202;
                    }
                }else{
                    if( !empty($result) ){
                        if(preg_match("/OK\:/i", $result)){
                            $data->success = true;
                            $data->message = "Echec recensement et message transmis";
                            $data->error = "";
                            $code = 202;
                        }else{
                            $data->success = false;
                            $data->error = $result;
                            $data->message = "Echec recensement et message non transmis";
                            $code = 202;
                        }
                    }else{
                        $data->success = false;
                        $data->error = $result;
                        $data->message = "Echec recensement et message non transmis";
                        $code = 202;
                    }
                }
            }else{
                $data->success = true;
                $data->message = "Rien à enrégistrer!";
                $data->error = "";
                $code = 202;
            }

        
        }

        $data->code = $code;

        // return $data;
        $this->writelog(json_encode($data));
    }

    public function checkElectorStatus($task_id)
    {
        do {
            // Wait for 5 seconds before making the next request
            sleep(5);

            // Check the task status
            $csvUrl = env('CSV_URL')??"http://127.0.0.1:5585";
            $statusResponse = Http::get("$csvUrl/check_elector_status/$task_id");

            $statusData = $statusResponse->json();

            // Log the response for debugging
            Log::info('Task Status:', $statusData);

            // Extract state and result from the response
            $state = $statusData['state'];
            
            if ($state === 'COMPLETED') {
                $result = $statusData['result'];
                if ($result['data']) {
                    // Perform action when result.data is true
                    return [$result['lvname'], $result['cardelect'], $result['data']];
                } else {
                    // Perform action when result.data is false
                    return [$result['lvname'], $result['cardelect'], $result['data']];
                }
            }

            if($state == 'FAILED')
                $state = 'COMPLETED';

        } while ($state !== 'COMPLETED');

        $this->writelog('Task did not complete successfully');

        return [null, false];
    }

    public function sendToOtherApis($urla, $content){
        $url = $urla;
        $result = "";
        // Define the data to be sent in the POST request body
        $data = array('text' => "$content");
        
        // Encode the data as JSON
        $json_data = json_encode($data);
        
        // Set up the cURL request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        // Execute the cURL request
        $response = curl_exec($ch);
        
        // Check for errors
        if(curl_errno($ch)){
            $response =  'Error: ' . curl_error($ch);
        }
        curl_close($ch);
        
        return $response;
    }

    public function is_validContact($phone){
        if(strlen(trim($phone)) == 10) return true;
        $rphone = "";
        if( preg_match("/225/i", trim($phone)) ) $rphone = preg_replace("/^(?:\+|)225/i", "", trim($phone));
        if(strlen(trim($rphone)) == 10) return true;

        return false;
    }

    public function cleanPhone($phone){
        return preg_replace("/^(?:\+|)225/i", "", trim($phone));
    }

    public function is_base64Str($cont){
        if( base64_encode(base64_decode($cont, true)) == $cont ) return true;

        if((bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $cont)) return true;

        return false;
    }
    
    public function sendMessage(array $numbers, string $sender, string $message){
        $new_date = date('Y-m-d H:i:s');
        $param = array(
            'username' => 'ELECTIO',
            'password' => '#m1n1m1SS@#',
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
}
