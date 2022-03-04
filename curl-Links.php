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

$webBook = array(); 

function returnXPathObj($item) 
{
    $xmlPageDom = new DomDocument();
    @$xmlPageDom->loadHTML($item);
    $xmlPageXPath = new DOMXPath($xmlPageDom); 
    return $xmlPageXPath;
}

$site = ''; // site url
$key = 'php';
$language = 'english';
$format = 'pdf';
$yearFrom = 2020;
$yearTo = 2022;

for ($yearFrom; $yearFrom<=$yearTo; $yearFrom++) 
{
    $webPage = curlGet($site.'/s/'.$key.'/?yearFrom='.$yearFrom.'&yearTo='.$yearTo.'&languages%5B0%5D='.$language.'&extensions%5B0%5D='.$format);
    $webPageXpath = returnXPathObj($webPage);
    $urls = $webPageXpath->query('//span[@class="totalCounter"]'); 

    $bookNumberStr = $urls->item(0)->nodeValue . "<br>";
    $bookNumberCast = preg_replace('/[^0-9.]+/', '', $bookNumberStr);
    $bookNumber = (int)$bookNumberCast;
    $iNumber = ceil($bookNumber/50);

    for ($i=1; $i<=$iNumber; $i++) {
        $webPage = curlGet($site.'/s/'.$key.'/?yearFrom='.$yearFrom.'&yearTo='.$yearTo.'&languages%5B0%5D='.$language.'&extensions%5B0%5D='.$format.'&page='.$i);
        $webPageXpath = returnXPathObj($webPage);
        $urls = $webPageXpath->query('//h3/a'); 
        if ($urls->length > 0) 
        {
            foreach ($urls as $item) {
                echo $item->getAttribute('href') . "<br>";
            }
        }

    }
} 