<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\EmailStatus;
use App\Models\Email;
use App\View;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
    public function __construct(protected Email $email, protected MailerInterface $mailer)
    {
    }
    public function registerEmail(array $customer): bool
    {
        if (empty($customer['email'])) {
            return false;
        }
        $data['firstname'] = $customer['name'] ?? 'anonymous';
        $html = View::make('email/welcomehtml', $data)->render();
        $queue = new Email();
        $queue->queue(
            new Address($customer['email']),
            new Address('mib@test.com'),
            'Welcome!',
            $html
        );
        return true;
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
