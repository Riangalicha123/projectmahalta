<?php

namespace App\Jobs;

use App\Traits\EmailTrait;

class SendReminderEmail
{
    use EmailTrait;

    public function run($params)
    {
        $to = $params['to'];
        $subject = $params['subject'];
        $message = $params['message'];
        $attachmentPath = $params['attachmentPath'];

        log_message('debug', "Sending reminder email to: $to, subject: $subject");
        $this->sendEmail($to, $subject, $message, $attachmentPath);
    }
}
