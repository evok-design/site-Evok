<?php
/**
 * Created by PhpStorm.
 * User: Vivien
 * Date: 23/09/2019
 * Time: 17:18
 */
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Repository\ActualitesRepository;
use App\Repository\NewsletterUsersRepository;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;


class TestCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:newsletter';

    private $mailer;
    private $em;
    private $repo;
    private $news;
    public $templating;

    public function __construct(\Swift_Mailer $mailer, Environment $templating, EntityManagerInterface $em, ActualitesRepository $repo, NewsletterUsersRepository $news)
    {
        parent::__construct();
        $this->mailer = $mailer;
        $this->em = $em;
        $this->templating = $templating;
        $this->repo = $repo;
        $this->news = $news;

    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Get last news and all users

        $actualite = $this->repo->lastCreated(1);
        $newsLettersUsers = $this->news->findAll();
        $listUser = [];

        foreach ($newsLettersUsers as $user){

            array_push($listUser, $user->getEmail());

        }


        // Nous récuperons les données de l'actualites

        $title = $actualite[0]->getTitre();
        $content = $actualite[0]->getNewsletterTextPreview();
        $image = $actualite[0]->getImgPrev();
        $slug = $actualite[0]->getSlug();
        $isPublish = $actualite[0]->getNewsletterPublish();



        // Si publié on ne le renvoie pas !

        if ($isPublish == false)

        {
            $message = (new \Swift_Message('[EVOKDESIGN] ' . $title))
                ->setTo($listUser)
                ->setFrom('noreply@evok.fr');


            $img = $message->embed(\Swift_Image::fromPath('/var/www/vhosts/evok-design.fr/httpdocs/public/uploads/actualites/'.$image));

            // Social Network Image

//            $youtubeImg = $message->embed(\Swift_Image::fromPath('https://evok-design.evok.fr/img/sn/Youtube.svg'));
            $linkedinImg = $message->embed(\Swift_Image::fromPath('/var/www/vhosts/evok-design.fr/httpdocs/public/img/sn/linkdin.svg'));
            $facebookImg = $message->embed(\Swift_Image::fromPath('/var/www/vhosts/evok-design.fr/httpdocs/public/img/sn/Facebook.svg'));
            $instagramImg = $message->embed(\Swift_Image::fromPath('/var/www/vhosts/evok-design.fr/httpdocs/public/img/sn/instagram.svg'));
            $twitterImg = $message->embed(\Swift_Image::fromPath('/var/www/vhosts/evok-design.fr/httpdocs/public/img/sn/twitter.svg'));
            $evokImg = $message->embed(\Swift_Image::fromPath('/var/www/vhosts/evok-design.fr/httpdocs/public/img/sn/logo.jpg'));



            $message->setBody( $this->templating->render(
                'actualites/newsletter.html.twig',
                array(
                    'contenu' => $content,
                    'titre' => $title,
                    'image' => $img,
                    'slug' => $slug,
//                    'youtube' => $youtubeImg,
                    'linkedin' => $linkedinImg,
                    'facebook' => $facebookImg,
                    'instagram' => $instagramImg,
                    'twitter'=> $twitterImg,
                    'evokImage' => $evokImg,

                )
            ),
                'text/html'
            );

            if ( $this->mailer->send($message) ){

                $output->writeln('Newsletters envoyées avec succès');

                // Nous modifions la variable de publication pour éviter la republication.

                $actualite[0]->setNewsletterPublish(true);
                $this->em->persist($actualite[0]);
                $this->em->flush();
            }

        }else{
            $output->writeln('Pas de nouvelle actualité, envoi interrompu.');
        }
    }
}