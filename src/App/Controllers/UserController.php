<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Post;
use App\Models\Email;
use App\Services\EmailService;
use App\View;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class UserController
{
    public function __construct(protected MailerInterface $mailer)
    {
    }

    #[Get('/users')]
    public function index(): string
    {
        return View::make('user/userForm');
    }
    #[Post('/users')]
    public function sendMail(): void
    {
        $name = htmlentities($_POST['name'], ENT_QUOTES);
        $email = htmlentities($_POST['email'], ENT_QUOTES);
        $firstname = explode(" ", $name)[0];

        $data['firstname'] = $firstname;
        $html = View::make('email/welcomehtml', $data);
        $text = View::make('email/welcometext', $data);

        $queue = new Email();
        $queue->queue(
            new Address(html_entity_decode($email)),
            new Address('gio@test.com'),
            'Welcome!',
            $html,
            $text
        );
        //emailService = new EmailService($queue, $this->mailer);
        //$emailService->sendQueuedEmails();
    }
}
