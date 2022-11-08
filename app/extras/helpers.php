<?php

function createPaymentMethod(){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.myidentitypass.com/api/v2/biometrics/merchant/data/verification/bvn",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'number' => $bvn
        ]),
        CURLOPT_HTTPHEADER => [
            "x-api-key: s7y52wur.i50dhsQilfkQvnFK7saRtopq7LSJLii5", //replace this with your own key
            "app-id: 05aab177-525a-45f4-b2d6-e83df1f4adaf",
            "content-type: application/json"

          ]
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      if($err){
        // there was an error contacting the myIdentitypass API
        die('Curl returned error: ' . $err);
      }

      $tranx = json_decode($response, true);
      return $tranx;
}