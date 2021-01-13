<?php

class Notifications extends Dbh
{

    public function get_notifications_by_user_id($user_id)
    {
        $sql = "SELECT 
                    unseen, 
                    notification, 
                    notification_type, 
                    notifications.created_at, 
                    notifications.user_id, 
                    username as created_by
                FROM notifications
                JOIN notification_types
                ON notifications.notification_type = notification_types.notification_type_id
                JOIN users
                ON notifications.created_by = users.user_id
                WHERE notifications.user_id = ?
                ORDER BY notification_id DESC";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        $notifications = $stmt->fetchAll();

        $unseen = 0;
        foreach ($notifications as $notification) {
            $unseen += $notification['unseen'];
        }
        return  array('notifications' => $notifications, 'num_unseen' => $unseen);
    }

    public function make_notifications_seen($user_id)
    {
        $sql = "UPDATE notifications SET unseen = 0 WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
    }
}
