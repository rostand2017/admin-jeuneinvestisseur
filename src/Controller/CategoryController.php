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
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        $image = $request->files->get("image");
        $id = $post->get('id');

        if( $id > 0)
            $category = $em->getRepository(Category::class)->find($id);
        else
            $category = new Category();
        try{
            if($image != null){
                $fileName = $this->uploadImage($image, $request);
                if( $id > 0){
                    //unlink($category->getImage());
                }
                $category->setImage($request->getHttpHost()."/".$this->getParameter("images2_directory").$fileName);
            }
        }catch (\Exception $e){
            return new JsonResponse(['status'=>0, 'mes'=> $e->getMessage()]);
        }

        $title = $post->get("category");
        $description = $post->get("description");
        if($id > 0 ){
            if( $title != '' && $category && $description != '')
            {
                $category->setTitle($title);
                $category->setDescription($description);
                $em->persist($category);
                $em->flush();
                return new JsonResponse(array(
                    "status"=>0,
                    "mes"=>"Champs modifiés avec succès"
                ));
            }else{
                return new JsonResponse(array(
                    "status"=>1,
                    "mes"=>"Renseignez les champs correctement"
                ));
            }

        }else{
            if($title != '' && $description != ''){
                $category->setTitle($title);
                $category->setDescription($description);
                $em->persist($category);
                $em->flush();
                return new JsonResponse(array(
                    "status"=>0,
                    "mes"=>"Catégorie ajoutée avec succès"
                ));
            }else{
                return new JsonResponse(array(
                    "status"=>1,
                    "mes"=>"Renseignez les champs correctement"
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


    /**
     * @param UploadedFile $file
     * @throws \Exception
     */
    private function uploadImage(UploadedFile $file, Request $request) {
        $imageAccepted = array("jpg", "png", "jpeg");
        if( in_array(strtolower($file->guessExtension()), $imageAccepted) ){
            $fileName = $this->getUniqueFileName().".".$file->guessExtension();
            $file->move($this->getParameter("images_directory"), $fileName);
            return $fileName;
        }else{
            throw new \Exception("Format d'image incorrect", 100);
        }
    }

    private function getUniqueFileName(){
        return md5(uniqid());
    }


}