<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\EmailStatus;
use App\Models\Email;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    public function __construct(protected Email $email, protected MailerInterface $mailer)
    {
    }

    public function sendQueuedEmails(): void
    {
        $emails = $this->email->findByEmailStatus(EmailStatus::QUEUE);

        foreach ($emails as $email) {
            $userMail = (new \Symfony\Component\Mime\Email())
                ->from(json_decode($email->meta)->from)
                ->to(json_decode($email->meta)->to)
                ->subject($email->subject)
                ->text($email->text_body)
                ->html($email->html_body);

            $this->mailer->send($userMail);
            $this->email->markEmailSent($email->id);
        }
    }
}
