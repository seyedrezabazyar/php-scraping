<?php

function curlPost($postUrl, $postFields, $successString) 
{
    $useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36';
    $cookie = 'cookie.txt'; // A file will be created to store cookies
    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // Prevent cURL from verifying SSL certificate
    curl_setopt($ch, CURLOPT_FAILONERROR, TRUE); // Script should fail silently on error
    curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE); // Use cookies
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); // Follow Location: headers
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Returning transfer as a string
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); // Setting cookiefile
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie); // Setting cookiejar
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent); // Setting useragent
    curl_setopt($ch, CURLOPT_URL, $postUrl); // Setting URL to POST to
    curl_setopt($ch, CURLOPT_POST, TRUE); // Setting method as POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields)); // Setting POST fields as array

    $results = curl_exec($ch);
    curl_close($ch); 

    if (strpos($results, $successString)) { // You can also use the str_contains(); function
        echo 'You have logged in successfully.';
        return $results;
    } else {
        echo 'There is a problem!';
        return FALSE;
    }
}

$postUrl = 'https://abitodo.ir/auth.php?action=login';
$userEmail = 'lomojap819@nitynote.com';
$userPass = 'Lomojap819@nitynote.com';

$postFields = array(
 'email' => $userEmail,
 'password' => $userPass,
//  'destination' => 'account',
//  'form_id' => 'loginform'
);

$successString = 'Folders'; // Setting success string to test
$loggedIn = curlPost($postUrl, $postFields, $successString);