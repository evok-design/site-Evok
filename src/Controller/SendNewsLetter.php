<?php
/**
 * Created by PhpStorm.
 * User: Vivien
 * Date: 18/09/2019
 * Time: 16:09
 */

namespace App\Controller;

use App\Entity\NewsletterUsers;
use App\Repository\NewsletterUsersRepository;
use App\Entity\Actualites;
use App\Repository\ActualitesRepository;
use App\Controller\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;

class SendNewsLetter implements EventSubscriberInterface
{
    private $mailer;
    public $templating;


    public function __construct(\Swift_Mailer $mailer, Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;

    }

    public static function getSubscribedEvents(): array
    {
        // TODO: Implement getSubscribedEvents() method.
        return[

          Events::NEWSLETTER_SEND => 'countdownNewLetter',

        ];
    }

    public function countdownNewletter(GenericEvent $event): void
    {

        $now = null;
        $actualite = $event->getSubject();
        $contenu = $actualite->getContenu();
        $title = $actualite->getTitre();
        $image = $actualite->getImgPrev();
        $now = new \DateTime();

        if ($now != null){

            $time = time();
            $interval = $time - $now->getTimestamp();

            if ( $interval >= 30){


                $message = (new \Swift_Message('[EVOKDESIGN] NEWSLETTER '))
                    ->setTo('v.michot@evok.fr')
                    ->setFrom('noreply@evok.fr');

                $img = $message->embed(\Swift_Image::fromPath('https://evok-design.evok.fr/uploads/actualites' . '/' . $image ));

                $message->setBody(
                    $this->templating->render(
                        'actualites/newsletter.html.twig',
                        array(
                            'contenu' => $contenu,
                            'titre' => $title,
                            'image' => $img,
                        )
                    ),
                    'text/html'
                );

                $this->mailer->send($message);


            }



        }




    }
}