<?php
/**
 * Created by PhpStorm.
 * User: Ross
 * Date: 12.10.2020
 * Time: 06:42
 */

namespace App\Controller;


use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends  AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function categoryAction(){
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render("home/category.html.twig", array(
            "categories" => $categories
        ));
    }

    /**
     * @Route("/categories/edit", name="edit_category")
     */
    public function editCategoryAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $post = $request->request;

        $title = $post->get("category");
        $id = $post->get('id');
        if($id > 0 ){
            $category = $em->getRepository(Category::class)->find($id);
            if( $title != '' && $category)
            {
                $category->setTitle($title);
                $em->persist($category);
                $em->flush();
                return new JsonResponse(array(
                    "status"=>0,
                    "mes"=>"Catégorie modifiée avec succès"
                ));
            }else{
                return new JsonResponse(array(
                    "status"=>1,
                    "mes"=>"Renseignez le champs catégorie"
                ));
            }

        }else{
            if($title != ''){
                $category = new Category();
                $category->setTitle($title);
                $em->persist($category);
                $em->flush();
                return new JsonResponse(array(
                    "status"=>0,
                    "mes"=>"Catégorie ajoutée avec succès"
                ));
            }else{
                return new JsonResponse(array(
                    "status"=>1,
                    "mes"=>"Renseignez le champs catégorie"
                ));
            }
        }
    }

    /**
     * @Route("/categories/{category}/delete", name="delete_category", requirements={"category"="\d+"})
     */
    public function deleteCategoryAction(Category $category){

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        try{
            $em->flush();
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Catégorie supprimée avec succès"
            ));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Impossible de supprimer cette catégorie"
            ));
        }
    }

}