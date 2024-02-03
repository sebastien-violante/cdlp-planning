<?php

namespace App\Services;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * class MailerService allows to generate an email whith the same format when a new client is registered or when a departure is validated. It depends on the given parameters
 */
class MailerService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * The function sendEmail allows to send a mail, depending on adresses, subject, title...It uses a specific template in templates/emails directory
     *
     * @param string $dsn
     * @param string $fromEmail
     * @param string $toEmail
     * @param string $ccEmail
     * @param string $subject
     * @param string $title
     * @param string $beginning
     * @param string $middle
     * @param string $end
     * @param string $client
     * @param string $site
     * @return void
     */
    public function sendEmail($dsn, $fromEmail, $toEmail1, $toemail2, $ccEmail, $subject, $title, $beginning, $middle, $end, $client, $site): void
    {
        $transport = Transport::fromDsn($dsn);
        $mailer = new Mailer($transport);
        $email = (new TemplatedEmail())
            ->from(new Address($fromEmail, 'Appartement Bénodet'))
            ->to($toEmail1)
            ->to($toemail2)
            ->cc($ccEmail)
            ->subject('Corniche de la plage : ' . $subject)
            ->htmlTemplate('informationMail.html.twig')
            ->context([
                'client' => $client,
                'subject' => $subject,
                'title' => $title,
                'beginning' => $beginning,
                'middle' => $middle,
                'end' => $end,
                'site' => $site,
            ]);
        $loader = new FilesystemLoader('../templates/emails');
        $twigEnv = new Environment($loader);
        $twigBodyRenderer = new BodyRenderer($twigEnv);
        $twigBodyRenderer->render($email);
        $mailer->send($email);
    }
}
