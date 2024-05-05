<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Parrain;
use App\Models\LieuVote;
use App\Models\AgentTerrain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CommonItemMobileController extends Controller
{
    protected $dataR = null;
    protected $ids = [];
    protected $len_data = 0;
    protected $counter = 0;

    public function treatgettext($requ){
        $inputs = $requ->all();
        $inputs = json_decode($inputs['datas']);
        $sms_id = [];
        $datas = [];
        foreach ($inputs as $input) {
            $data = [];
            array_push($sms_id, $input->id);
            array_push($data, $input->id);
            array_push($data, $input->body);
            array_push($data, $input->address);
            array_push($data, $input->datetime);
            $datas[] = $data;
        }
        return $datas;
    }

    public function checker(Request $request){
        // $allItem = $request->all();
        // $collect = $request->collect();
        //$content = $request->getContent();
        $respos = new \stdClass();
        $debug = print_r($request->all(), true);
        $this->writelog($debug);
        if($request->has('text')){
            //$content = $request->text;
            //$respos = $this->setDataToDB($request, $content, -1);
        }else{
            $this->dataR = $this->treatgettext($request);
            //$contents = $this->dataR[1];
            //$ids = [];
            $this->len_data = sizeof($this->dataR);
            //dd($this->dataR);
            if($this->len_data > 0){
                $dataok = $this->dataR[$this->counter];
                
                //do{
                    $dda = $this->setDataToDB($request, $dataok[1], $dataok[0]);
                //}while( ($this->len_data-1) >= $this->counter);
                $respos->status = true;
                $respos->id_sms = $this->ids;
                $respos->message = 'message successfull record';
                $respos->code = 200;
                
            }else{
                $respos->status = true;
                $respos->id_sms = -1;
                $respos->message = 'message unsuccessfull record';
                $respos->code = 202;
            }
            // foreach ($this->dataR as $datai){
            //     array_push($ids, $dda->id_sms);
            // }
        }

        //dd($content);
        
        return response()->json($respos, $respos->code);
    }
    
    public function setDataToDB($request, $content, $idd){
        
        $this->writelog($content);
        
        $data = new \stdClass();
        $this->ids[] = $idd;
        if(empty($content)){
            
            if($this->counter <= $this->len_data-1){
                $this->counter++;
                $dda = $this->setDataToDB($request, $this->dataR[$this->counter][1], $this->dataR[$this->counter][0]);
                
            }
            $data->status = true;
            $data->id_sms = -1;
            $data->message = 'message unsuccessfull record';
            $data->code = 202;
            return $data;
            
        }
        $cfinal = "";
        $code = 200;
        if($this->is_base64Str($content)){
            $cfinal = base64_decode($content, true);
        }else{
            $cfinal = $content;
        }

        if(preg_match("/PAR\:/i", $cfinal)){
            $arrCont = explode("*", $cfinal);
            
            if(!empty($arrCont[4])){
                if($this->is_validContact($arrCont[4]) && $this->is_validContact($arrCont[9])){
                    //dd("Valide num ".$arrCont[2]." ".$arrCont[8]);
                    $data2 = $this->lauchProcForParrain($cfinal);
                    
                    if($this->counter < $this->len_data-1){
                        $this->counter = $this->counter + 1;
                        $datz = $this->dataR[$this->counter];
                        $dda = $this->setDataToDB($request, $datz[1], $datz[0]);
                        //$this->ids[] = $idd;
                    }
                    
                    if($data2->code == 200){
                        $data->status = true;
                        $data->id_sms = $idd;
                        $data->message = 'message successfull record';
                        $data->code = 200;
                        return $data;
                    }
                    
                    $data->status = true;
                    $data->id_sms = -1;
                    $data->message = 'message unsuccessfull record';
                    $data->code = 202;
                    return $data;
                }else{
                    if($this->counter < $this->len_data-1){
                        $this->counter = $this->counter + 1;
                        $datz = $this->dataR[$this->counter];
                        $dda = $this->setDataToDB($request, $datz[1], $datz[0]);
                        //$this->ids[] = $idd;
                    }
                    
                    $data->status = true;
                    $data->id_sms = -1;
                    $data->message = 'message unsuccessfull record';
                    $data->code = 202;
                    return $data;
                }
            }else{
                if(sizeof($arrCont) <= 5){
                    //dd("Valide num ".$arrCont[2]." ".$arrCont[8]);
                    $data2 = $this->lauchProcForParrain($cfinal);
                    
                    if($this->counter < $this->len_data-1){
                        $this->counter = $this->counter + 1;
                        $datz = $this->dataR[$this->counter];
                        $dda = $this->setDataToDB($request, $datz[1], $datz[0]);
                        //$this->ids[] = $idd;
                    }
                    
                    if($data2->code == 200){
                        $data->status = true;
                        $data->id_sms = $idd;
                        $data->message = 'message successfull record';
                        $data->code = 200;
                        return $data;
                    }
                    
                    $data->status = true;
                    $data->id_sms = -1;
                    $data->message = 'message unsuccessfull record';
                    $data->code = 202;
                    return $data;
                }else{
                    if($this->counter < $this->len_data-1){
                        $this->counter = $this->counter + 1;
                        $datz = $this->dataR[$this->counter];
                        $dda = $this->setDataToDB($request, $datz[1], $datz[0]);
                        //$this->ids[] = $idd;
                    }
                    
                    $data->status = true;
                    $data->id_sms = -1;
                    $data->message = 'message unsuccessfull record';
                    $data->code = 202;
                    return $data;
                }
            }
            
            if($this->counter < $this->len_data-1){
                $this->counter = $this->counter + 1;
                $datz = $this->dataR[$this->counter];
                $dda = $this->setDataToDB($request, $datz[1], $datz[0]);
                //$this->ids[] = $idd;
            }
            
        }
        
        return $data;
        
    }
    
    public function writelog($content){
        $filename = date("Y-m-d")."_saver_gb_mob". ".txt"; // create filename based on current date
        
        $path = dirname(__FILE__, 4)."/".$filename;
        
        if (!file_exists($path)) { // check if file exists
          touch($path); // create the file if it doesn't exist
        }
        $file = fopen($path, "a");
        fwrite($file, $content."\n");
        fclose($file);
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

    public function lauchProcForParrain($cont){
        $data = new \stdClass();
        $code = 404;
        $arrCont = explode("*", $cont);

        if(sizeof($arrCont) <= 5){

            $timestampCr = strtotime($arrCont[1]);
            $created_it = date("Y-m-d H:i:s", $timestampCr);
            //dd($created_it);
            $parrain = Parrain::where("created_at", $created_it)->first();
            
            if($parrain){
                $data->success = true;
                $data->message = "Enrégistrement trouvé, mise à jour!";
                $data->error = "";
                $code = 200;

                $parrain->observation = $arrCont[3];
                $parrain->recenser = $arrCont[4];
                $parrain->save();
            }else{
                $data->success = true;
                $data->message = "Enrégistrement introuvale, non mise à jour!";
                $data->error = "";
                $code = 200;
            }

            $data->code = $code;

            return $data;
        }

        $agTerrainPhone = $this->cleanPhone($arrCont[4]);
        $parrainPhone = $this->cleanPhone($arrCont[9]);
        $agTerrain = AgentTerrain::with("lieuVote")->where("telephone", $agTerrainPhone)->first();

        if(!$agTerrain) {
            $data->success = false;
            $data->error = "";
            $data->message = "Agent non reconnu!";
            $code = 202;

        }else{

            if(sizeof($arrCont) > 4){
                
                
                $timestampCr = strtotime($arrCont[1]);
                $date_obj = Carbon::createFromFormat('d/m/Y', $arrCont[10]);
                $lieuvote = LieuVote::where("code", "like", "%".$arrCont[11]."%")->first();
                $dateNaiss = $date_obj->format('Y-m-d H:i:s');
                $created_it = date("Y-m-d H:i:s", $timestampCr);
                //dd("Valide num ".$agTerrainPhone." ".$dateNaiss);
                $observation = "";
                $agent_recences = "";
                if(array_key_exists(14, $arrCont)) $observation = $arrCont[14];
                if(array_key_exists(15, $arrCont)) $agent_recences = $arrCont[15];
                $parrainCr = [
                    'nom_pren_par' => "$agTerrain->nom $agTerrain->prenom",
                    'telephone_par' => "$agTerrainPhone",
                    'recenser' => "$agent_recences",
                    'nom' => "$arrCont[5]",
                    'prenom' => "$arrCont[6]",
                    'list_elect' => "$arrCont[7]",
                    'cart_elect' => "$arrCont[8]",
                    'telephone' => "$parrainPhone",
                    'date_naiss' => "$dateNaiss",
                    'code_lv' => optional($lieuvote)->libel??"AUTRE CIRCONSCRIPTION",
                    'residence' => "$arrCont[12]",
                    'profession' => "$arrCont[13]",
                    'observation' => "$observation",
                    'status' => "Non traité",
                    'created_at' => $created_it,
                    'updated_at' => $created_it,
                ];
                //dd($parrainCr);
                $parrain = Parrain::create(
                    $parrainCr
                );

                if($parrain){
                    $result = $this->sendMessage(array("225".$parrainPhone), 'ERIC TABA', "Cher(e) ".strtoupper($arrCont[5])." ".ucwords($arrCont[6]).",\nJe vous remercie de soutenir ma Candidature à la Mairie de Cocody.\nA très bientot !\n\nEric TABA");
                    
                    if( !empty($result) ){
                        if(preg_match("/OK\:/i", $result)){
                            $data->success = true;
                            $data->message = "Recensement éffectué avec succès et message transmis ";
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
                            $code = 200;
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
                $code = 200;
            }

        
        }

        $data->code = $code;

        return $data;
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

}