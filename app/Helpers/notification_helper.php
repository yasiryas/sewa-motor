<?php

use App\Models\NotificationModel;

function pushNotification($userId, $type, $title, $message, $link = null)
{
    $notif = new NotificationModel();

    return $notif->insert([
        'user_id' => $userId,
        'type'    => $type,
        'title'   => $title,
        'message' => $message,
        'link'    => $link,
        'is_read' => 0,
        'created_at' => date('Y-m-d H:i:s')
    ]);
}
