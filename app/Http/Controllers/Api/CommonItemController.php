<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Parrain;
use App\Models\LieuVote;
use Illuminate\Support\Str;
use App\Models\AgentTerrain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessParrain;
use Illuminate\Support\Facades\Storage;

class CommonItemController extends Controller
{
    
    protected $dataR = null;

    public function treatgettext($requ){
        $inputs = $requ->all();
        $inputs = json_decode($inputs['datas']);
        $sms_id = [];
        $data = [];
        foreach ($inputs as $input) {
            
            //Log::info($input->address);
            array_push($data, $input->address);
            
            //Log::info($input->body);
            array_push($data, $input->body);
            
            //Log::info($input->datetime);
            array_push($data, $input->datetime);
            
            //Log::info($input->id);

            array_push($data, $input->id);
            array_push($sms_id, $input->id);
        }

        // return response()->json([
        //     'status' => true ,
        //     'id_sms' => $sms_id ,
        //     'message' => 'message successfull record',
        // ], 200);
        return $data;
    }

    public function checker(Request $request){
        // $allItem = $request->all();
        // $collect2 = $request->collect();
        // $content2 = $request->getContent();
        $content = $request->text;
        // dd($content, $request);
        // $this->dataR = $this->treatgettext($request);
        // $content = $this->dataR[2];
        // $body = $request->all();
        // $body2 = $request->input();
        // $this->writelog($body);
        // $this->writelog($body2);
        $this->writelog($content);
        // $this->writelog($collect2);
        // $this->writelog($request->body);
        //dd("ok");
        $data = new \stdClass();


        if($request->has("type")){

            if($request->type == "RECENS"){

                $dataId = $request->input('otherId');
                $date = explode("*", $dataId)[0];
            
                // Finding the parent by created_at equal to the extracted date
                $timestampCr = strtotime($date);
                $created_it = date("Y-m-d H:i:s", $timestampCr);
                //dd($created_it);
                $parrain = Parrain::where("created_at", $created_it)->first();
            
                $data->success = true;
                $data->error = "";
                $data->message = "Parrain introuvé !!";
                
                if ($parrain) {
                    // Decoding photoContent from base64
                    $code = 301;
                    $data->message = "Parrain trouvé et Photo non recu !!";
                    if($request->input('imageContent')){
                        
                        $code = 201;
                        
                        $image = Str::after($request->input('imageContent'), 'base64,');
                        $image = str_replace(' ', '+', $image);
                        $photoContent = base64_decode($image);
                        
                        // Storing the decoded photo in storage/app/public/parrains/
                        $filename = 'parrains/' . Str::uuid() . '_photo.jpg'; // Assuming jpg format
                        Storage::disk('public')->put($filename, $photoContent);
                        
                        // You may want to update the parent record with the filename or any other relevant information
                        $parrain->photo = $filename;
                        $parrain->save();
                        
                        $data->message = "Photo recu avec succes";

                        return response()->json($data, $code);
                    }

                    return response()->json($data, $code);
                } else {
                    return response()->json($data, 301);
                }

            }

        }

        // dd($request->text);
        if(empty($content)) return response()->json($data, 202);
        $cfinal = "";
        $code = 200;
        if($this->is_base64Str($content)){
            $cfinal = base64_decode($content, true);
        }else{
            $cfinal = $content;
        }

        if(preg_match("/PAR/i", $cfinal)){
            $arrCont = explode("*", $cfinal);
            if( strlen($arrCont[0]) <= 4 && $arrCont[0] == "PDCD" ){
                if(!empty($arrCont[6])){
                    if($this->is_validContact($arrCont[3]) && $this->is_validContact($arrCont[7])){
                        //dd("Valide num ".$arrCont[2]." ".$arrCont[8]);
                        $data->success = false;
                        $data->message = "Processus en cours de traitement !";
                        $code = 201;
                        // $data2 = $this->lauchProcForParrain($cfinal);
                        ProcessParrain::dispatch($cfinal);
                        return response()->json($data, $code);
                        // exit();
                        // if($data2->code == 200){
                        //     return response()->json([
                        //         'status' => true ,
                        //         'id_sms' => $this->dataR[1],
                        //         'message' => 'message successfull record',
                        //     ], 200);
                        // }
                        
                        // return response()->json([
                        //     'status' => false ,
                        //     'id_sms' => -1,
                        //     'message' => 'Vérifier les numéros de téléphone!',
                        // ], 202);
                    }else{
                        $data->success = false;
                        $data->error = "Vérifier les numéros de téléphone!";
                        $code = 202;
                        return response()->json($data, $code);
                        // exit();
                        // return response()->json([
                        //     'status' => false ,
                        //     'id_sms' => -1,
                        //     'message' => 'Vérifier les numéros de téléphone!',
                        // ], 202);
                    }
                }else{
                    if(sizeof($arrCont) <= 6){
                        //dd("Valide num ".$arrCont[2]." ".$arrCont[8]);
                        $data->success = false;
                        $data->message = "Processus en cours de traitement !";
                        $code = 201;
                        // $data2 = $this->lauchProcForParrain($cfinal);
                        ProcessParrain::dispatch($cfinal);
                        return response()->json($data, $code);
                        // exit();
                        // if($data2->code == 200){
                        //     return response()->json([
                        //         'status' => true ,
                        //         'id_sms' => $this->dataR[3],
                        //         'message' => 'message successfull record',
                        //     ], 200);
                        // }
                        
                        // return response()->json([
                        //     'status' => false ,
                        //     'id_sms' => -1,
                        //     'message' => 'Processus introuvable!',
                        // ], 202);
                    }else{
                        $data->success = false;
                        $data->error = "Processus introuvable!";
                        $code = 202;
                        return response()->json($data, $code);
                        // exit();
                        // return response()->json([
                        //     'status' => false ,
                        //     'id_sms' => -1,
                        //     'message' => 'Processus introuvable!',
                        // ], 202);
                    }
                }
            }
        }

        //dd($data);
        //Log::debug($data);

        return response()->json($data, $code);
    }
    
    public function writelog($content){
        $filename = date("Y-m-d")."_saver_coco". ".txt"; // create filename based on current date
        
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

        if(sizeof($arrCont) <= 6){

            $timestampCr = strtotime($arrCont[1]);
            $created_it = date("Y-m-d H:i:s", $timestampCr);
            //dd($created_it);
            $parrain = Parrain::where("created_at", $created_it)->first();
            
            if($parrain){
                $data->success = true;
                $data->message = "Enrégistrement trouvé, mise à jour!";
                $data->error = "";
                $code = 200;

                $parrain->extrait = $arrCont[3];
                $parrain->observation = $arrCont[4];
                $parrain->recenser = $arrCont[5];
                $parrain->save();
            }else{
                $data->success = true;
                $data->message = "Enrégistrement introuvale, non mise à jour!";
                $data->error = "";
                $code = 202;
            }

            $data->code = $code;

            return $data;
        }

        $agTerrainPhone = $this->cleanPhone($arrCont[3]);
        $parrainPhone = $this->cleanPhone($arrCont[7]);
        $agTerrain = AgentTerrain::with("lieuVote")->where("telephone", $agTerrainPhone)->first();

        if(!$agTerrain) {
            $data->success = false;
            $data->error = "";
            $data->message = "Agent non reconnu!";
            $code = 202;

        }else{

            if(sizeof($arrCont) > 4){
                
                $timestampCr = strtotime($arrCont[1]);
                // $timestampDateNaissCr = strtotime($arrCont[6]);
                // $dateNaiss = date("Y-m-d H:i:s", $timestampDateNaissCr);
                $date_obj = Carbon::createFromFormat('d/m/Y', str_replace("-", "/", $arrCont[6]));
                // $lieuvote = LieuVote::where("libel", "like", "%".$arrCont[9]."%")->first();
                $dateNaiss = $date_obj->format('Y-m-d H:i:s');
                $created_it = date("Y-m-d H:i:s", $timestampCr);
                //dd("Valide num ".$agTerrainPhone." ".$dateNaiss);
                $extrait = "";
                $observation = "";
                $agent_recences = "";
                if(array_key_exists(12, $arrCont)) $extrait = $arrCont[12];
                if(array_key_exists(13, $arrCont)) $observation = $arrCont[13];
                if(array_key_exists(14, $arrCont)) $agent_recences = $arrCont[14];
                $parrainCr = [
                    'nom_pren_par' => "$agTerrain->nom $agTerrain->prenom",
                    'telephone_par' => "$agTerrainPhone",
                    'recenser' => "$agent_recences",
                    'nom' => "$arrCont[4]",
                    'prenom' => "$arrCont[5]",
                    'list_elect' => "$arrCont[10]",
                    'cni_dispo' => "$arrCont[11]",
                    'extrait' => "$extrait",
                    'telephone' => "$parrainPhone",
                    'date_naiss' => "$dateNaiss",
                    'code_lv' => optional($arrCont[9])?"$arrCont[9]":"AUTRE CIRCONSCRIPTION",
                    'residence' => "N/A",
                    'profession' => "$arrCont[8]",
                    'observation' => "$observation",
                    'status' => "Non traité",
                    'created_at' => $created_it,
                    'updated_at' => $created_it,
                ];
                //dd($parrainCr);
                $parrain = Parrain::create(
                    $parrainCr
                );

                $result = "No sms error message";
                if($parrain){
                    $result = $this->sendMessage(array("225".$parrainPhone), 'ELECTIO', "Cher(e) ".strtoupper($arrCont[4])." ".ucwords($arrCont[5]).",\nMerci de nous rejoindre dans la Grande Famille du PDCI-RDA.\nGardes un contact permanent avec ton Parrain.\n\nPDCI Digital");
                
                
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