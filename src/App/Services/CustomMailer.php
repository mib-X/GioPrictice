<?php


namespace App\Services;


use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\RawMessage;

class CustomMailer implements MailerInterface
{
    private Transport\TransportInterface $transport;

    public function __construct(protected string $dsn)
    {
        $this->transport = Transport::fromDsn($this->dsn);
    }

    public function send(RawMessage $message, Envelope $envelope = null): void
    {
        $this->transport->send($message, $envelope);
    }
}