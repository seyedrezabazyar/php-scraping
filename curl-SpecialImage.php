<?php

function curlGet($url) 
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $results = curl_exec($ch);
    curl_close($ch);
    return $results;
}

function returnXPathObject($item) 
{
    $xmlPageDom = new DomDocument();
    @$xmlPageDom->loadHTML($item);
    $xmlPageXPath = new DOMXPath($xmlPageDom);
    return $xmlPageXPath;
}

$packtPage = curlGet('https://www.balyan.ir/'); 
$packtPageXpath = returnXPathObject($packtPage); 
$coverImage = $packtPageXpath->query('//img[@class="attachment-full size-full"]/@src');

if ($coverImage->length > 0) 
{
    $imageUrl = $coverImage->item(0)->nodeValue; 
    $imageName = end(explode('/', $imageUrl)); 

    if (getimagesize($imageUrl)) 
    {
        $imageFile = curlGet($imageUrl); 
        $file = fopen($imageName, 'w');
        fwrite($file, $imageFile);
        fclose($file); 
    }
}