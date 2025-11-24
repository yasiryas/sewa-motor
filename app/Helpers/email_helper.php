<?php

use CodeIgniter\Email\Email;

if (!function_exists('sendBookingEmail')) {
    function sendBookingEmail($userEmail, $userName, $bookingData)
    {
        try {
            $email = \Config\Services::email();

            $data = [
                'user_name' => $userName,
                'booking_id' => $bookingData['booking_id'],
                'motor_name' => $bookingData['motor_name'],
                'start_date' => $bookingData['start_date'],
                'end_date' => $bookingData['end_date'],
                'total_price' => $bookingData['total_price'],
                'days' => $bookingData['days'] ?? 1
            ];

            $message = view('emails/booking_confirmation', $data);

            $email->setTo($userEmail);
            $email->setFrom('sewaskuterjogja.com@gmail.com', 'Rental Motor App');
            $email->setSubject('Konfirmasi Booking Rental Motor - ID: ' . $bookingData['booking_id']);
            $email->setMessage($message);

            if ($email->send()) {
                log_message('info', 'Email berhasil dikirim ke: ' . $userEmail);
                return true;
            } else {
                log_message('error', 'Gagal mengirim email ke: ' . $userEmail);
                log_message('debug', 'Email debug: ' . $email->printDebugger(['headers']));
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'Error sendBookingEmail: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('sendAdminNotification')) {
    function sendAdminNotification($bookingData)
    {
        try {
            $email = \Config\Services::email();

            $data = [
                'user_name' => $bookingData['user_name'],
                'booking_id' => $bookingData['booking_id'],
                'motor_name' => $bookingData['motor_name'],
                'start_date' => $bookingData['start_date'],
                'end_date' => $bookingData['end_date'],
                'total_price' => $bookingData['total_price']
            ];

            $message = view('emails/admin_notification', $data);

            $email->setTo('yasir123983@gmail.com'); // Ganti dengan email admin sebenarnya
            $email->setFrom('sewaskuterjogja.com@gmail.com', 'Rental Motor App');
            $email->setSubject('Notifikasi Booking Baru - ID: ' . $bookingData['booking_id']);
            $email->setMessage($message);

            if ($email->send()) {
                log_message('info', 'Notifikasi admin berhasil dikirim');
                return true;
            } else {
                log_message('error', 'Gagal mengirim notifikasi admin');
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'Error sendAdminNotification: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('sendBookingStatusEmail')) {
    function sendBookingStatusEmail($userEmail, $userName, $bookingId, $newStatus, $bookingData)
    {
        try {
            $email = \Config\Services::email();

            $data = [
                'user_name' => $userName,
                'booking_id' => $bookingId,
                'new_status' => $newStatus,
                'motor_name' => $bookingData['motor_name'],
                'start_date' => $bookingData['start_date'],
                'end_date' => $bookingData['end_date'],
                'total_price' => $bookingData['total_price'],
                'status' => $newStatus
            ];

            $message = view('emails/booking_status_update', $data);

            $email->setTo($userEmail);
            $email->setFrom('sewaskuterjogja.com@gmail.com', 'Rental Motor App');
            $email->setSubject('Update Status Booking - ID: ' . $bookingId);
            $email->setMessage($message);

            if ($email->send()) {
                log_message('info', 'Email berhasil dikirim ke: ' . $userEmail);
                return true;
            } else {
                log_message('error', 'Gagal mengirim email ke: ' . $userEmail);
                log_message('debug', 'Email debug: ' . $email->printDebugger(['headers']));
                return false;
            }
        } catch (\Exception $e) {
            log_message('error', 'Error sendBookingStatusEmail: ' . $e->getMessage());
            return false;
        }
    }
}
