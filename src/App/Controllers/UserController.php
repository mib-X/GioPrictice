<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Post;
use App\View;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class UserController
{
    public function __construct(protected MailerInterface $mailer)
    {
    }

    #[Get('/users')]
    public function index()
    {
        return View::make('user/userForm')->render();
    }
    #[Post('/users')]
    public function sendMail()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $firstname = explode(" ", $name)[0];

        $data['firstname'] = $firstname;
        $html = View::make('email/welcomehtml', $data)->render();
        $text = View::make('email/welcometext', $data)->render();

        $userMail = (new Email())
            ->from('test@gio.vagrant.internal')
            ->to('mib.varbex@gmail.com')
            ->subject('Welcome!')
            ->replyTo($email)
            ->text($text)
            ->html($html);

        $this->mailer->send($userMail);
    }
}