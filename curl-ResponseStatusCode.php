<?php

 function curlGet($url) 
 {
    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36');
    
    $results = curl_exec($ch); 

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    
    if ($httpCode==200)
    {
        return $results; 
    } 
    else
    {
        return false;
    } 
 }

 $webPage = curlGet('https://www.seyedrezabazyar.com/');

 if ($webPage == true)
 {
    echo $webPage;
 }
 else
 {
     echo 'This page is not available!';
 }
