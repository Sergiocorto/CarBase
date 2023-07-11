<?php


namespace App\Http\Services;


class VinCodeDecoder
{
    static public function vinCodeDecode(string $vinCode)
    {
        $postdata = http_build_query(
            array(
                'format' => 'json',
                'data' => "$vinCode"
            )
        );
        $opts = array('http' =>
            array(
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'method' => 'POST',
                'content' => $postdata
            )
        );
        $apiURL = "https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVINValuesBatch/";
        $context = stream_context_create($opts);
        $fp = fopen($apiURL, 'rb', false, $context);
        if(!$fp)
        {
            echo "in first if";
        }
        $response = @stream_get_contents($fp);
        if($response == false)
        {
            echo "in second if";
        }
        $response = json_decode($response, true);
        $results = $response['Results'][0];
        $make = $results['Make'];
        $model = $results['Model'];
        $model_year = $results['ModelYear'];

         return [
             'make' => $make,
             'model' => $model,
             'model_year' => $model_year
         ];
    }
}
