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
        return View::make('user/userForm')->render();
    }
    #[Post('/users')]
    public function sendMail(): void
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $firstname = explode(" ", $name)[0];

        $data['firstname'] = $firstname;
        $html = View::make('email/welcomehtml', $data)->render();
        $text = View::make('email/welcometext', $data)->render();


        $queue = new Email();
        $queue->queue(
            new Address($email),
            new Address('gio@test.com'),
            'Welcome!',
            $html,
            $text
        );
        $emailService = new EmailService($queue, $this->mailer);
        $emailService->sendQueuedEmails();
    }
}
