<?php
/**
 * Created by PhpStorm.
 * User: Ross
 * Date: 10/19/2018
 * Time: 4:08 PM
 */

namespace App\Controller;


use App\Entity\Emails;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsLetterController extends AbstractController
{

    /**
     * @Route("/newsletters", name="newsletters")
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $newsletters = $em->getRepository(Emails::class)->findAll();
        return $this->render("home/newsletters.html.twig", array(
            "newsletters" => $newsletters,
        ));
    }
    /**
     * @Route("/newsletters/diffusion", name="diffusion")
     */
    public function diffusionAction(){
        return $this->render("home/diffusion.html.twig");
    }

    /**
     * @Route("/newsletters/send-messages", name="send_messages")
     */
    public function sentAction(Request $request, \Swift_Mailer $mailer){
        $post = $request->request;
        $message = $post->get("message");
        if( !empty( trim($message) ) )
        {
            $em = $this->getDoctrine()->getManager();
            $emails = $em->getRepository(Emails::class)->findAll();
            if(!empty($emails)){
                foreach ($emails as $email){
                    if( preg_match("#.+@[a-zA-Z]+\.[a-zA-Z]{2,6}#", $email) ){
                        $mes = (new \Swift_Message("Annonce CryptoWithTincs"))
                            ->setFrom('contact@cryptowithtincs.com')
                            ->setTo($email->getEmail())
                            ->setBody(
                                $message,
                                "text/html"
                            );
                        $mailer->send($mes);
                    }
                }
                return new JsonResponse(array(
                    "status"=>0,
                    "mes"=>"Message envoyé avec succès"
                ));
            }
        }
        return new JsonResponse(array(
            "status"=>1,
            "mes"=>"Renseignez le champs message"
        ));
    }
}