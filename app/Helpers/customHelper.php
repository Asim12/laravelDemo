<?php 

    if(!function_exists('testing')){

        if (!function_exists('dynamicCURLHit')) {
            function dynamicCURLHit($req) {
                $jsondataPayLoad   =  $req['req_params'];
                $req_url           =  $req['req_url'];

                $jsondataPayLoad = json_encode($jsondataPayLoad);
        
                $curl = curl_init();
                curl_setopt_array($curl, [
                CURLOPT_URL =>  $req_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $jsondataPayLoad,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
                ]);
        
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                return $response;
            }
        } //end num

    }//end if function exists
