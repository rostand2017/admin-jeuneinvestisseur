<?php

namespace App\Controller;

use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/home", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, UserPasswordEncoderInterface $encoder): Response
    {
        if ($this->getUser()) {
             return $this->redirectToRoute('home_page');
        }

        $this->createDefaultAccount($encoder);
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    private function createDefaultAccount(UserPasswordEncoderInterface $encoder){
        $em = $this->getDoctrine()->getManager();
        $admins = $em->getRepository(Admin::class)->findAll();
        if(count($admins) == 0){
            $admin = new Admin();
            $admin->setPassword($encoder->encodePassword($admin, "admin"));
            $admin->setEmail("admin@gmail.com");
            $admin->setRoles(["ROLE_ADMIN"]);
            $em->persist($admin);
            $em->flush();
        }
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
