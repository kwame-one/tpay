<?php

namespace App\Traits;

use App\Transaction;

trait Utils {

    public function getNetwork($phone) {
        $net = substr($phone, 0, 3);

        if(in_array($net, ["020", "050"])) {
            $network = "VODAFONE";
        }else if(in_array($net, ["024", "054", "055"])) {
            $network = "MTN";
        }else if(in_array($net, ["027", "057"])) {
            $network = "TIGO";
        }else if(in_array($net, ["026", "056"])) {
            $network = "AIRTEL";
        }

        return $network;

    }


    public function payViaMomo($phone, $amount, $voucher = null) {

        $transction_id = time() . mt_rand() . auth()->user()->id;

        $network = $this->getNetwork($phone);

        $data = array(
            'PBFPubKey' => env('PUBLIC_KEY'),
            'currency' => 'GHS',
            'country' => 'GH',
            'payment_type' => 'mobilemoneygh',
            'amount' => $amount,
            'phonenumber' => $phone,
            'network' => $network,
            'voucher' => $voucher,
            'email' => 'alexfreeman221@gmail.com',
            'txRef' => $transction_id,
            'orderRef' => 'Credit TPAY Wallet',
            'is_mobile_money_gh' => 1,
        );


        $key = $this->getKey(env("SECRET_KEY"));

        $dataReq = json_encode($data);

        $post_enc = $this->encrypt3Des($dataReq, $key);

        $postdata = array(
            'PBFPubKey' => env('PUBLIC_KEY'),
            'client' => $post_enc,
            'alg' => '3DES-24');

        $status = $this->makeHttpRequest(
            "https://api.ravepay.co/flwv3-pug/getpaidx/api/charge",
            "POST", $postdata, array('Content-Type: application/json')
        );

        if($status) {
            Transaction::create([
                'code' => $transction_id,
                'type' => 'deposit',
                'total' => $data['amount'],
                'user_id' => auth()->user()->id,
                'phone' => $data['phonenumber']
            ]);

            return true;
        }

        return false;

    }


    public function withdrawViaMomo($phone, $amount) {
        $network = $this->getNetwork($phone);

        $phone = "233". substr($phone, 1);

        $user = auth()->user();
        $transction_id = time() . mt_rand() . auth()->user()->id;

        $data = [
            'account_bank' => $network,
            'account_number' => $phone,
            'amount' => $amount,
            'secKey' => env('SERVER_KEY'),
            "narration" => 'New Transfer',
            'currency' => "GHS",
            'reference' => 'Withdrawal',
            'beneficiary_name' => "$user->surname $user->other_names"
        ];

        $status = $this->makeHttpRequest(
            "https://api.ravepay.co/v2/gpx/transfers/create",
            "POST", $data,  array('Content-Type: application/json')
        );

        if($status) {
            Transaction::create([
                'code' => $transction_id,
                'type' => 'withdrawal',
                'total' => $data['amount'],
                'user_id' => auth()->user()->id,
                'phone' => $data['account_number']
            ]);

            return true;
        }

        return false;

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

            $headers =  array(
                "Authorization: key=$server_key",
                "Content-Type: application/json",
            );

            $this->makeHttpRequest("https://fcm.googleapis.com/fcm/send", "POST", $data, $headers);


        }
    }

    public function makeHttpRequest($url, $method, $data, $headers) {

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($ch);
        $err = curl_error($ch);

        if($err) return false;

        return $response;

        curl_close($ch);
    }
}
