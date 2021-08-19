<?php

namespace App\Controller;

use App\Entity\Creation;
use App\Form\ContactType;
use App\Repository\CreationRepository;
use App\Repository\FichesRepository;
use App\Repository\ParcoursRepository;
use App\Repository\PresseARepository;
use App\Repository\PresseVRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PagesController extends AbstractController
{
//    /**
//     * @Route("/", name="index")
//     */
//    public function index()
//    {
//
//        return $this->render('pages/index.html.twig', [
//            'controller_name' => 'PagesController',
//        ]);
//    }

    /**
     * @Route("/agence-communication-nancy-metz-lorraine", name="agence")
     */
    public function agence()
    {
        return $this->render('pages/agence.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }

//    /**
//     * @Route("/creation-site-internet-nancy-metz-lorraine", name="web")
//     */
//    public function web(){
//
//        $prestations = [
//            [
//                'link' => '#',
//                'description' => '',
//                'image' => 'realisation-1.jpg'
//            ],
//            [
//                'link' => '#',
//                'description' => '',
//                'image' => 'realisation-1.jpg'
//            ],
//            [
//                'link' => '#',
//                'description' => '',
//                'image' => 'realisation-1.jpg'
//            ],
//
//        ];
//
//        $creationRepository = $this->getDoctrine()->getRepository(Creation::class);
//        $otherCreations = $creationRepository->getRelated(0);
//
//        return $this->render('pages/web.html.twig', ['prestations' => $prestations, 'otherCreations' => $otherCreations]);
//    }

    /**
     * @Route("/equipe", name="equipe")
     */
    public function equipe()
    {
        return $this->render('pages/equipe.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }

    /**
     * @Route("/magazine-parcours", name="parcours")
     */
    public function magazine(ParcoursRepository $parcoursRepository)
    {
        return $this->render('pages/magazine.html.twig', [
            'parcours' => $parcoursRepository->findBy([],['createdAt'=>'DESC']),
        ]);
    }

    /**
     * @Route("/presse", name="presse")
     */
    public function EspacePresse()
    {
        return $this->render('pages/EspacePresse.html.twig', [

        ]);
    }

    /**
     * @Route("/Articles-de-presse", name="presseAV")
     */
    public function EspacePresseAV(PresseVRepository $presseVRepository , PresseARepository $presseARepository)
    {
        return $this->render('pages/EspacePresse.html.twig', [
            'presseA' => $presseARepository->findAll(),
            'presseV' => $presseVRepository->findAll()
        ]);
    }

    /**
     * @Route("/Fiches-produits", name="fiches")
     */
    public function FicheProd(FichesRepository $fichesRepository)
    {
        return $this->render('pages/FichesProd.html.twig', [
            'fiches' => $fichesRepository->findBy([],['createdAt'=>'DESC'])
        ]);
    }

    /**
     * @Route("/mentions-legales", name="mentions")
     */
    public function mentions()
    {
        return $this->render('pages/mentions.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }

    /**
    * @Route("/contact", name="contact")
    */
        public function contact(Request $request, \Swift_Mailer $mailer)
        {

            $options = [];

            //DEFINITION PAR DEFAUT DU SELECTEUR DE SUJET
            if(!is_null($request->get('subject')) && $request->get("subject") != ""){
                $options['subject'] = $request->get('subject');
            }

            $form = $this->createForm(ContactType::class, null, $options);
            $form->handleRequest($request);
            $error = false;

            if($form->isSubmitted() && $form->isValid()) {

                if(is_null($request->get('consent')) || $request->get('consent') != "on"){
                    $error = true;
                    $request->getSession()->getFlashBag()->add('danger', 'Veuillez cocher la case nous autorisant à exploiter vos données dans le cadre de la demande de contact.');
                }else if(!$this->captchaverify($request->get('g-recaptcha-response'))){
                    $request->getSession()->getFlashBag()->add('danger', 'Veuillez cocher la case "Je ne suis pas un robot"');
                }
                $name = $form->get('name')->getData();
                $email = $form->get('email')->getData();
                $subject = $form->get('subject')->getData();
                $message = $form->get('message')->getData();
                $attachment = $form->get('attachment')->getData();

                $dateId = new \DateTime();
                $generatedId = $dateId->getTimestamp();


                if(!is_null($attachment)){
                    $test = $attachment->getClientOriginalName();
                    $file = $test;
                    $extension =  pathinfo($file, PATHINFO_EXTENSION);

                    if($attachment->getClientSize() < 3000000){
                        if(!in_array($extension, ['png','jpg','jpeg','pdf','doc','docx'])){
                            $error = true;
                            $request->getSession()->getFlashBag()->add('danger',"Vos documents doivent être au format .png ou .jpg ou .jpeg ou .pdf ");
                        }else{
                            try{
                                $attachment->move(
                                    $this->getParameter('emails_directory'),
                                    'attachment-'.$generatedId.'.'.$attachment->getClientOriginalName()
                                );
                            } catch (FileException $e) {
                                $error = $e;
                            }
                        }
                    }else{
                        $error = true;
                        $request->getSession()->getFlashBag()->add('danger',"La taille d'un/des fichier(s) doit être inférieure à 3 Mo, vous pouvez héberger votre contenu sur <a href=\"https://wetransfer.com\" target=\"_blank\">Wetransfert</a> et nous communiquer le lien de téléchargement dans votre message.");
                    }
                }


                if(!$error) {

                    if ( $subject == 'Devis' || $subject == 'Informations'){
                        $destination = ["evokdesign@evok.fr"];
                    }elseif($subject == "Candidature"){
                        $destination = "recrutement@evok.fr";  
                    }

                    try {
                        $message = (new \Swift_Message('[EVOKDESIGN.FR] Demande de contact'))
                            ->setFrom('noreply@evok.fr')
                            ->setTo($destination)
                            ->setBody(
                                $this->renderView(
                                    'emails/contact.html.twig',
                                    array(
                                        'name' => $name,
                                        'email' => $email,
                                        'subject' => $subject,
                                        'message' => $message
                                    )
                                ),
                                'text/html'
                            );

                        if (!is_null($attachment)) {
                            $message->attach(\Swift_Attachment::fromPath($this->getParameter('emails_directory') . '/attachment-' . $generatedId . '.' . $attachment->getClientOriginalName(), 'piecejointe.' . $attachment->getClientOriginalName() ));
                        }

                        mail($destination, $subject, $message);

                        if ($mailer->send($message)) {
                            $request->getSession()->getFlashBag()->add('success', 'Merci pour votre message, nous vous recontacterons au plus vite.');
                            $form = $this->createForm(ContactType::class, null, $options);
                        }

                    } catch (FileException $e) {
                        $request->getSession()->getFlashBag()->add('danger', 'Erreur lors de l\'envoi du mail' . $e);
                    }
                }

            }else if($form->isSubmitted() && !$form->isValid()){
                foreach ($form->getErrors() as $f){
                    $request->getSession()->getFlashBag()->add('danger', $f->getMessage());
                }
            }

            return $this->render('pages/contact.html.twig', [
                'controller_name' => 'PagesController',
                'form' => $form->createView()
            ]);
        }

    private function captchaverify($recaptcha){
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "secret"=>"6LeGU6oUAAAAAI_bMneZslWpCcdrm9uBrwAxOgIu","response"=>$recaptcha));
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);

        return $data->success;
    }

}
