<?php

function sendFCM($tokens, $title, $message, $link = null)
{
    if (empty($tokens)) return;

    $serverKey = env('FIREBASE_SERVER_KEY'); // taruh di .env

    $payload = [
        'registration_ids' => is_array($tokens) ? $tokens : [$tokens],
        'data' => [
            'title' => $title,
            'message' => $message,
            'url' => $link,
            'time' => date('H:i'),
        ],
        'priority' => 'high',
    ];

    $headers = [
        'Authorization: key=' . $serverKey,
        'Content-Type: application/json',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_exec($ch);
    curl_close($ch);
}
