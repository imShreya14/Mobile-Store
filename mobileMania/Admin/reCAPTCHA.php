<!-- Site key: 6Lc0CucoAAAAAI_N8ee8B8FGZrnQpViATB0HOrvw -->
<!-- Secret key: 6Lc0CucoAAAAANhFnTO5WlLfyDYrXrOS7tG_mGQI -->

<?php

function verifyRecaptcha($responseKey, $userIP, $secretKey) {
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = array(
        'secret' => $secretKey,
        'response' => $responseKey,
        'remoteip' => $userIP
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    return json_decode($response);
}

?>
