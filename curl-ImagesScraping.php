<?php

$curl = curl_init(); 

$search_string = "esteghlal";
$url = "https://www.varzesh3.com/search/lenz?q=$search_string";

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true) ;

$result = curl_exec($curl);

preg_match_all("!https://static.farakav.com/files/insta[^\s]*?.jpg!",$result, $matches);

$images = array_values(array_unique($matches[0]));

for ($i = 0; $i < count($images); $i++)
{
    echo "<div style='float:left;margin:10px;'>";
    echo "<a href='$images[$i]' target='_blank'><img src='$images[$i]' width='300' height='300'><br /></a>";
    echo "</div>";
}

curl_close($curl);