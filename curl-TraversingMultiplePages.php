<?php

function curlGet($url) {
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $results = curl_exec($ch);
    curl_close($ch); 
    return $results; 
}

function returnXPathObj($item) 
{
    $xmlPageDom = new DomDocument(); 
    @$xmlPageDom->loadHTML($item); 
    $xmlPageXPath = new DOMXPath($xmlPageDom); 
    return $xmlPageXPath; 
}

$resultsPages = array();
$bookPages = array();

$initialResultsPageUrl = 'https://www.seyedrezabazyar.com/hafez/ghazal/';
$resultsPages[] = $initialResultsPageUrl;
$initialResultsPageSrc = curlGet($initialResultsPageUrl); 
$resultsPageXPath = returnXPathObj($initialResultsPageSrc);
$resultsPageUrls = $resultsPageXPath->query('//div[@class="pagination"]/a/@href');
if ($resultsPageUrls->length > 0) 
{
    for ($i = 0; $i < $resultsPageUrls->length; $i++) 
    {
    $resultsPages[] = $resultsPageUrls->item($i)->nodeValue; 
    }
}

$uniqueResultsPages = array_values(array_unique($resultsPages));

foreach ($uniqueResultsPages as $resultsPage) 
{
    $resultsPageSrc = curlGet($resultsPage);
    $booksPageXPath = returnXPathObj($resultsPageSrc);
    $bookPageUrls = $booksPageXPath->query('//h2[@class="post-box-title"]/a/@href');

    if ($bookPageUrls->length > 0) 
    {
        for ($i = 0; $i < $bookPageUrls->length; $i++) 
        {
            $bookPages[] = $bookPageUrls->item($i)->nodeValue;
        }
    }

    $booksPageXPath = NULL;
    $bookPageUrls = NULL;
    sleep(rand(1, 3));

}

$uniqueBookPages = array_values(array_unique($bookPages));
print_r($uniqueBookPages);