<?php
namespace Web;

use \Pimple\Container;
use \Pimple\ServiceProviderInterface;
use \Silex\Application;
use \Silex\Api\BootableProviderInterface;
use \Silex\Api\EventListenerProviderInterface;
use \Symfony\Component\EventDispatcher\EventDispatcherInterface;
use \Symfony\Component\HttpKernel\KernelEvents;
use \Symfony\Component\HttpKernel\Event\FilterResponseEvent;
//use Web\PHPMailer;
use Web\phpmailer\SMTP;

class PhpMailerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['mail'] = function () use ($app) {
            //Create a new PHPMailer instance
            $mail = new \Web\PHPMailer();
            $mail->isSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->Host = 'vvmm-hbgv.accessdomain.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'webmaster@heroes.arubamarketing.net';
            $mail->Password = 'P@ss**2017';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->CharSet = "UTF-8";
            $mail->setFrom('webmaster@heroes.arubamarketing.net', 'Heroes Aruba');
            return $mail;
        };
    }

    public function boot(Application $app)
    {
    }

    public function subscribe(Container $app, EventDispatcherInterface $dispatcher)
    {
        $dispatcher->addListener(KernelEvents::REQUEST, function (FilterResponseEvent $event) use ($app) {
        });
    }
}
