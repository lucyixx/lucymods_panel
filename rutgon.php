<?php

    $long_url = urlencode('yourdestinationlink.com');

    $api_token = '0ddecd1a5f75a4492866d0e55595f5467785468b';

    $api_url = "https://linkbulks.com/api?api={$api_token}&url={$long_url}&alias=viertan";

    $result = @json_decode(file_get_contents($api_url),TRUE);

    var_dump($result)
?>