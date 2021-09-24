<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectID;
use MongoDB\BSON\UTCDateTime;
// use Illuminate\Support\Facades\DB;
use MongoDB\BSON\DateTime;
use MongoDB;


class users extends Model
{
    protected $connection = 'mongodb';
 
    public function testingData(){

        $date = DateTime::createFromFormat( 'Y-m-d\TH:i:s.uT', date('Y-m-d H:i:s'));
        $mDate = new \MongoDB\BSON\UTCDateTime( $date->format('U') * 1000 );
        var_dump($date, $mDate->toDateTime());


        $date = date('Y-m-d H:i:s');
        $olderDate = date('Y-m-d H:i:s', strtotime('-20 days'));
        echo "<br>".$date;
        echo '<br>older date: '.$olderDate;

        $countUser = users::find( [ '_id' => new ObjectID('60e4423df25b360e136367c2') ]);
        return $countUser;
    }

    public function getUserData(){

        $olderTime = new UTCDateTime(new \DateTime('-12 hours'));
        $lookup = [
            [
                '$match' => [
                    'application_mode' => ['$in' => ['both', 'live']],
                    '$or' => [

                        ['account_block'  => ['$exists' => false]],
                        ['account_block'  => 'no'],
                    ],

                    '$or'  => [
                        ['api_key_valid_checking' => ['$exists' => false]],
                        ['api_key_valid_checking' => ['$lte' => $olderTime]]
                    ],

                    '$or' => [

                        ['count_invalid_api' => ['$exists' => false]],
                        ['count_invalid_api' => ['$lte' => 0]]
                    ],
                
                    '$and' => [
                        [
                            'api_key' => ['$exists' => true],
                        ],
                        [
                            'api_key' => ['$nin' => ['', null] ],
                        ],
                        [
                            'api_secret' => ['$exists' => true],
                        ],
                        [
                            'api_secret' => ['$nin' => ['', null] ],
                        ],
                    ],
                ]
            ],
            [
                '$project' =>[
                    '_id'                   =>  '$_id',
                    'api_key'               =>  '$api_key',
                    'api_secret'            =>  '$api_secret',
                    'username'              =>  '$username',
                    'api_key_secondary'     =>  '$api_key_secondary',
                    'api_secret_secondary'  =>  '$api_secret_secondary'

                ]
            ],
            [
                '$sort' => ['api_key_valid_checking' => 1]
            ],
            [
                '$limit' => 1
            ]

        ];
        $get_users = users::raw()->aggregate($lookup);
        $filter_Users  =  iterator_to_array($get_users);
        
        return $filter_Users; 
    }//end model

    public function validationChecking(){

        // $olderTime = $this->mongo_db->converToMongodttime(Date('Y-m-d H:i:s',strtotime('-12 hours') ));
        
        $olderTime = new UTCDateTime(new \DateTime('-12 hours'));

        $lookup = [
            [
                '$match' => [

                    '$and' => [
                        [
                            'trading_ip' => ['$exists' => true],
                        ],
                        [
                            'trading_ip' => ['$nin' => ['', null] ],
                        ],
                    ],
                    'application_mode' => ['$in' => ['both', 'live']],
                    '$or' => [

                        ['account_block'  => ['$exists' => false]],
                        ['account_block'  => 'no'],
                    ],

                    '$or'  => [
                        ['api_key_valid_checking' => ['$exists' => false]],
                        ['api_key_valid_checking' => ['$lte' => $olderTime]]
                    ],

                    '$or' => [

                        ['count_invalid_api' => ['$exists' => false]],
                        ['count_invalid_api' => ['$lte' => 0]]
                    ],
                ]
            ],
            [
                '$project' =>[
                    '_id'                   =>  '$_id',
                    'username'              =>  '$username',
                    'trading_ip'            =>  '$trading_ip',
                ]
            ],
            [
                '$sort' => ['api_key_valid_checking' => 1]
            ],
            [
                '$limit' => 1
            ]

        ];
        
        $data = users::raw()->aggregate($lookup);
        $data = iterator_to_array($data);

        return $data;
    }

    public function updateUserRecord($update_array, $admin_id){

        users::raw()->updateOne(['_id' =>  new ObjectID((string)$admin_id)], ['$set' => $update_array]);
        return true;
    }


}
