<?php

namespace App\Traits;

trait Utils {


    public function pay() {
        $data = array(
            'PBFPubKey' => env('PUBLIC'),
            'currency' => 'GHS',
            'country' => 'GH',
            'payment_type' => 'mobilemoneygh',
            'amount' => '30',
            'phonenumber' => '054709929300',
            'network' => 'MTN',
            'email' => 'tester@flutter.co',
            'txRef' => 'MXX-ASC-4578',
            'orderRef' => 'MXX-ASC-90929',
            'is_mobile_money_gh' => 1,
        );


        $key = $this->getKey(env("SECRET"));

        $dataReq = json_encode($data);

        $post_enc = $this->encrypt3Des($dataReq, $key);
    }

    public function deposit() {

    }

    public function withdraw() {

    }

    function getKey($seckey){
        $hashedkey = md5($seckey);
        $hashedkeylast12 = substr($hashedkey, -12);

        $seckeyadjusted = str_replace("FLWSECK-", "", $seckey);
        $seckeyadjustedfirst12 = substr($seckeyadjusted, 0, 12);

        $encryptionkey = $seckeyadjustedfirst12.$hashedkeylast12;
        return $encryptionkey;

    }



    function encrypt3Des($data, $key){
        $encData = openssl_encrypt($data, 'DES-EDE3', $key, OPENSSL_RAW_DATA);
        return base64_encode($encData);
    }



    public function notifyUser($title, $msg) {
        $token = auth()->user()->fcm_token;

        $server_key = env('SERVER_KEY');

        $data = [
           "to" => $token,
          "data" => [
                "message" => $msg,
                "title" => $title
           ]
        ];

        if($token != null) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($data),
              CURLOPT_HTTPHEADER => array(
                "Authorization: key=$server_key",
                "Content-Type: application/json",
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
        }
    }
}
