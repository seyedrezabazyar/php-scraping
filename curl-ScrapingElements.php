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

$webInfo = array(); 

function returnXPathObject($item) 
{
    $xmlPageDom = new DomDocument(); 
    @$xmlPageDom->loadHTML($item); 
    $xmlPageXPath = new DOMXPath($xmlPageDom); 
    return $xmlPageXPath; 
}

$word = 'water'; // Write your favorite words in English

$webPage = curlGet('https://dictionary.cambridge.org/dictionary/english/'.$word); 
$webPageXpath = returnXPathObject($webPage); 
$title = $webPageXpath->query('//span[@class="hw dhw"]'); 

if ($title->length > 0) 
{
    $webInfo['word'] = $title->item(0)->nodeValue; 
}

$release = $webPageXpath->query('//span[@class="pos dpos"]'); 

if ($release->length > 0) {
    $webInfo['word_type'] = $release->item(0)->nodeValue; 
}

// Use the appropriate style to display the pronunciations correctly
$release = $webPageXpath->query('//span[@class="us dpron-i "]/span[@class="pron dpron"]'); 

if ($release->length > 0) {
    $webInfo['US_pronunciation'] = $release->item(0)->nodeValue; 
}

// Use the appropriate style to display the pronunciations correctly
$release = $webPageXpath->query('//span[@class="uk dpron-i "]/span[@class="pron dpron"]'); 

if ($release->length > 0) {
    $webInfo['UK_pronunciation'] = $release->item(0)->nodeValue; 
}
 
$overview = $webPageXpath->query("//div[@class='hflx1']"); 

if ($overview->length > 0) 
{
    $webInfo['description'] = trim($overview->item(0)->nodeValue);
}

$author = $webPageXpath->query('//ul[@class="hax hul-u hul-u0 lmb-10"]/li'); 

if ($author->length > 0) 
{
    for ($i = 0; $i < $author->length; $i++) 
    {
    $webInfo['More meanings'][] = $author->item($i)->nodeValue;
    }
}

 print_r($webInfo);