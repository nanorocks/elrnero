<?php

namespace App\Controller;

use MailerSend\MailerSend;
use Symfony\Component\Mime\Email;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use MailerSend\Helpers\Builder\Personalization;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class MailerController extends AbstractController
{
    #[Route('/email', name: 'send_email')]
    public function sendEmail(): Response
    {
        $mailersend = new MailerSend(['api_key' => 'mlsn.b20ad11a77fdfede2f502b0bd2cd5c8102b6f92299e8d24b8fbf9db2af96a7ec']);

        $recipients = [
            new Recipient('andrejnankov@gmail.com', 'Andrej Nankov'),
        ];

        $personalization = [
            new Personalization('andrejnankov@gmail.com', [
                    'product' => 'ID1111',
                    'shipping' => 'n/a',
                    'order_number' => '132313213',
                    'support_email' => ''
            ])
        ];

        $emailParams = (new EmailParams())
            ->setFrom('MS_z7uctV@trial-351ndgw8v8rgzqx8.mlsender.net')
            ->setFromName('Elrnero App')
            ->setRecipients($recipients)
            ->setSubject('Subject')
            ->setTemplateId('7dnvo4d0me9g5r86')
            ->setPersonalization($personalization);

        $mailersend->email->send($emailParams);
        // Return a response indicating the email was sent
        return new Response('Email sent successfully!');
    }

    #[Route('/certificate', name: 'send_email_certificate')]
    public function sendEmailCertificate(): Response
    {
        $mailersend = new MailerSend(['api_key' => 'mlsn.b20ad11a77fdfede2f502b0bd2cd5c8102b6f92299e8d24b8fbf9db2af96a7ec']);

        $recipients = [
            new Recipient('andrejnankov@gmail.com', 'Andrej Nankov'),
        ];

        $personalization = [
            new Personalization('andrejnankov@gmail.com', [
                'date' => 'January 13, 2024 17:33',
                'name' => 'Andrej Nankov',
                'course' => 'Digital Marketing Essentials',
            ])
        ];

        $emailParams = (new EmailParams())
            ->setFrom('MS_z7uctV@trial-351ndgw8v8rgzqx8.mlsender.net')
            ->setFromName('Elrnero App')
            ->setRecipients($recipients)
            ->setSubject('Subject')
            ->setTemplateId('351ndgwnrq5gzqx8')
            ->setPersonalization($personalization);

        $mailersend->email->send($emailParams);
        // Return a response indicating the email was sent
        return new Response('Email sent successfully!');
    }
}