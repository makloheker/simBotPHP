<?php
function sendRequest($text) {
    $url = 'https://api.simsimi.vn/v1/simtalk';
    $headers = [
        'Content-Type: application/x-www-form-urlencoded'
    ];
    $data = http_build_query([
        'text' => $text,
        'lc' => 'id'
    ]);

    $options = [
        'http' => [
            'header'  => implode("\r\n", $headers),
            'method'  => 'POST',
            'content' => $data,
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        return "req fail";
    }

    $responseData = json_decode($response, true);
    return $responseData['message'] ?? 'no msg';
}

while (true) {
    echo "you>: ";
    $handle = fopen ("php://stdin","r");
    $inputText = trim(fgets($handle));

    if (in_array(strtolower($inputText), ["exit", "quit", "keluar", "murtad"])) {
        echo "ended\n";
        break;
    }

    $message = sendRequest($inputText);
    echo "bot>: " . $message . "\n";
}
?>
