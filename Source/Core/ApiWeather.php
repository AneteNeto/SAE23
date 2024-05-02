<?php

//require_once "../../config/config.php";
 class ApiWeather 
{
    public function __construct(){

    }

    public function callApi(string $ville):?array
    {
        //$api=CONF_API_URL.$ville.CONF_API_PARAMS.CONF_API_KEY;
        $api= "https://api.openweathermap.org/data/2.5/weather?q={$ville}&lang=fr&units=metric&APPID=bc6c4dbdd8355327830016c12370d05e";
        $curl = curl_init($api);
        curl_setopt_array($curl,[
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_CUSTOMREQUEST=>"GET",
            CURLOPT_TIMEOUT=>3
        ]);
        
        $meteo = curl_exec($curl);
        
        if($meteo===false || curl_getinfo($curl,CURLINFO_HTTP_CODE)!== 200){
            return null; 
        }
        $results=[];
        $meteo=json_decode($meteo,true);
        $results=[
                'temp'=>$meteo['main']['temp'],
                'description'=>$meteo['weather'][0]['description'],
                'icon'=>$meteo['weather'][0]['icon'],
                'vent'=>$meteo['wind']['speed'],
                'date'=> $meteo['dt'], 
        ];
        curl_close($curl);
        return $results;
    }
}




