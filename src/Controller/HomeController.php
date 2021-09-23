<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Contacts;
use App\Entity\Emails;
use App\Entity\User;
use App\Entity\Visitor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home_page")
     */
    public function index(): Response
    {
        $visitorRep = $this->getDoctrine()->getRepository(Visitor::class);
        $contacts = $this->getDoctrine()->getRepository(Contacts::class)->findAll();
        $emails = $this->getDoctrine()->getRepository(Emails::class)->findAll();
        $monthVisitors = $visitorRep->getMonthVisitors();
        $yearVisitors = $this->getDoctrine()->getRepository(Visitor::class)->getYearVisitors();


        $monthViewers = $visitorRep->getMonthViewers();
        $monthViewers = BlogController::getDayWithViewers($monthViewers);

        return $this->render('home/index.html.twig', [
            'contacts' => count($contacts),
            'emails' => count($emails),
            'yearVisitors' => $yearVisitors,
            'monthVisitors' => $monthVisitors,
            'monthViewers' => $monthViewers,
        ]);
    }

    /**
     * @Route("/contacts", name="contacts")
     */
    public function contacts(): Response
    {
        $contacts = $this->getDoctrine()->getRepository(Contacts::class)->findBy([], ["createdat"=>"desc"]);
        return $this->render('home/contacts.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Route("/change_password", name="reset_password")
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $error = null;
        $success = null;
        if($request->isMethod(Request::METHOD_POST)){
            $result = $this->changePassword($request, $passwordEncoder);
            $success = $result[0];
            $error = $result[1];
        }
        return $this->render('home/reset_password.html.twig', compact("error", "success"));
    }

    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $password = $request->request->get('password');
        $newPassword = $request->request->get('newPassword');
        $error = null;
        $success = null;
        if( $passwordEncoder->isPasswordValid($this->getUser(), $password) ){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(Admin::class)->findOneBy(['email'=>$this->getUser()->getUsername()]);
            $user->setPassword($passwordEncoder->encodePassword($this->getUser(), $newPassword));
            $em->persist($user);
            $em->flush();
            $success = "Mot de passe modifié avec succès";
        }else{
            $error = "Mot de passe incorrect";
        }
        return [$success, $error];
    }
}
