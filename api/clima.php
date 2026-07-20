<?php

$cidade = $cidade ?? '';
if ($cidade === '') {
    return [];
}

$url = 'https://api.hgbrasil.com/weather';

$queryString = http_build_query([
    'city_name' => $cidade,
    'key' => 'COLOQUE_SUA_KEY'
]);

$response = file_get_contents($url . '?' . $queryString);

//header('Content-Type: application/json');

//echo $response;

return json_decode($response, true);

?>
