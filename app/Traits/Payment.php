<?php 

namespace App\Traits;

trait Payment {
   

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
}