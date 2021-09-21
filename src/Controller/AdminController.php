<?php
/**
 * Created by PhpStorm.
 * User: Ross
 * Date: 12.10.2020
 * Time: 06:42
 */

namespace App\Controller;


use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends  AbstractController
{
    /**
     * @Route("/admins", name="admins")
     */
    public function adminAction(){
        $admins = $this->getDoctrine()->getRepository(Admin::class)->findAll();
        return $this->render("home/admin.html.twig", array(
            "admins" => $admins
        ));
    }


    /**
     * @Route("/admins/edit", name="edit_admin")
     */
    public function editAdminAction(Request $request, UserPasswordEncoderInterface $encoder){

        $em = $this->getDoctrine()->getManager();
        $post = $request->request;

        $email = $post->get("email");
        $password = $post->get("password");
        $id = $post->get('id');

        $existingEmail = $em->getRepository(Admin::class)->findOneBy(['email'=>$email]);

        if($id > 0 ){
            $admin = $em->getRepository(Admin::class)->find($id);
            if( $email != '' && $admin)
            {
                if($existingEmail && $existingEmail->getEmail() != $admin->getEmail())
                    return new JsonResponse(['status'=>1, "mes"=>"Cette adresse email existe déjà"]);
                if($password && strlen($password) < 8)
                    return new JsonResponse(['status'=>1, "mes"=>"Le mot de passe doit comporter au moins 8 caractères"]);
                if($password)
                    $admin->setPassword($encoder->encodePassword($this->getUser(), $password));

                $admin->setEmail($email);
                $em->persist($admin);
                $em->flush();
                return new JsonResponse(array(
                    "status"=>0,
                    "mes"=>"Utilisateur modifié avec succès"
                ));
            }else{
                return new JsonResponse(array(
                    "status"=>1,
                    "mes"=>"Renseignez une adresse email"
                ));
            }

        }else{
            if($existingEmail)
                return new JsonResponse(['status'=>1, "mes"=>"Cette adresse email existe déjà"]);
            if(strlen($password) < 8)
                return new JsonResponse(['status'=>1, "mes"=>"Le mot de passe doit comporter au moins 8 caractères"]);
            if($email != ''){
                $admin = new Admin();
                $admin->setEmail($email);
                $admin->setPassword($encoder->encodePassword($this->getUser(), $password));
                $admin->setRoles(["ROLE_ADMIN"]);
                $em->persist($admin);
                $em->flush();
                return new JsonResponse(array(
                    "status"=>0,
                    "mes"=>"Utilisateur ajouté avec succès"
                ));
            }else{
                return new JsonResponse(array(
                    "status"=>1,
                    "mes"=>"Renseignez une adresse email"
                ));
            }
        }
    }

    /**
     * @Route("/admins/{admin}/delete", name="delete_admin", requirements={"admin"="\d+"})
     */
    public function deleteAdminAction(Admin $admin){

        $em = $this->getDoctrine()->getManager();
        $em->remove($admin);
        try{
            $em->flush();
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Utilisateur supprimé avec succès"
            ));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Impossible de supprimer cet utilisateur"
            ));
        }
    }

}