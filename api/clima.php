<?php

$url = 'https://api.hgbrasil.com/weather';

$queryString = http_build_query([
    'city_name' => $cidade,
    'key' => 'SUA_CHAVE'
]);

$response = file_get_contents($url . '?' . $queryString);

return json_decode($response, true);

?>