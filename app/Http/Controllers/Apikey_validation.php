<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\DateTime;

class Apikey_validation extends Controller
{
    public function __construct(){

        $this->users = new users();
    }

    // api key checking and swap the api key if invalid and check again after 6 hours in next step
    public function api_key_checking(){

        $response = $this->users->validationChecking();    
        echo "<br>Count : ".count($response);
        if(count($response) > 0){
            echo '<br>tradingIp: '.$response[0]['trading_ip'];

            if( $response[0]['trading_ip'] == '3.227.143.115'){

                $Ipname = 'ip1';
            }elseif($response[0]['trading_ip'] == '3.228.180.22'){
    
                $Ipname = 'ip2';
            }elseif($response[0]['trading_ip'] == '3.226.226.217'){
    
                $Ipname = 'ip3';
            }elseif($response[0]['trading_ip'] == '3.228.245.92'){
    
                $Ipname = 'ip4';
            }else{
    
                exit;
            }

            $url = "https://".$Ipname.".digiebot.com/apiKeySecret/validateApiKeySecretAdmin";

            // check api is valid or not 
            echo "<br>".(string)$response[0]['_id'];
            $payLoadExchangeVarify = [
                'user_id'    =>  (string)$response[0]['_id']
            ];

            $req_arr = [
                'req_type'     =>  'POST',
                'req_url'      =>  $url,
                'req_params'   =>  $payLoadExchangeVarify,
            ];
            $resp      = dynamicCURLHit($req_arr);//helper function call
            $respData  = json_decode($resp);

            // if($respData->success == 1 || $respData->api_key == "VALID"){

                $update_array = [
                    'is_api_key_valid'      =>  "yes",
                    'count_invalid_api'     =>  0,
                    'account_block'         =>  'no',
                    'api_key_valid_checking'=> new UTCDateTime(new \DateTime())
                ];

                echo "<pre>";print_r($update_array);
                // $this->users->updateUserRecord($update_array, $response[0]['_id']);
                    // for again request to binance wait for 3 sec and then send second call
                // $db->users->updateOne(['_id' => $this->mongo_db->mongoId((string)$response[0]['_id']) ], ['$set' => $update_array ]);
                // $db->user_investment_binance->updateOne(['admin_id' => (string)$response[0]['_id'] ], ['$set' => ['exchange_enabled' => 'yes' ]]); 
            // }else{

            //     $db->user_investment_binance->updateOne(['admin_id' => (string)$response[0]['_id'] ], ['$set' => ['exchange_enabled' => 'no' ]]); 
            //     $db->users->updateOne(['_id' => $this->mongo_db->mongoId((string)$response[0]['_id']) ], ['$set' =>  ['api_key_valid_checking' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')) ,'is_api_key_valid' => "no", 'count_invalid_api'  => 1]]);
            // }
            echo "<br>SuccessFully Updated";
        }//end if
        echo "<br>Done";

    }//end function
}
