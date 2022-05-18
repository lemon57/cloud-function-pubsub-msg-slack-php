<?php

use Google\CloudFunctions\CloudEvent;

$log = fopen('php://stderr', 'wb');

function subscription_pubsub(CloudEvent $cloudevent)
{
    include 'config.php';
    global $log;
    $pubSubData = base64_decode($cloudevent->getData()['message']['data']);
    // fwrite($log, $pubSubData . PHP_EOL);

    var_dump($pubSubData);
    $text['text'] = $pubSubData;
    $text_to_send = json_encode($pubSubData); 
    var_dump(json_encode($pubSubData));
    var_dump('{"text": "'.$pubSubData.'"}');

    $url = $slack_webhook;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = [
        "Content-Type: application/json",
        "Accept: application/json",
    ];
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, '{"text": "'.$pubSubData.'"}');

    $result = curl_exec($curl);
    curl_close($curl);

    return $result;
}
