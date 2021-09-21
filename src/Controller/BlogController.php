<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\News;
use App\Tools\Thumbnails;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository(News::class)->findBy(["isDeleted"=>false], ['createdat'=>'desc']);
        $categories = $em->getRepository(Category::class)->findAll();
        $news = $paginator->paginate(
            $news,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('blog/index.html.twig', array("news" =>$news, "categories"=>$categories));
    }
    /**
     * @Route("/blog/b_{news}", name="news_details")
     */
    public function detailsNews(News $news): Response
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->render('blog/edit_news.html.twig', array("news" =>$news, "categories"=>$categories));
    }
    /**
     * @Route("/blog/new", name="create_news")
     */
    public function createNews(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $news = new News();
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->render('blog/edit_news.html.twig', array("categories"=>$categories, "news"=>$news));
    }

    /**
     * @Route("/blog/delete/{news}", name="delete_news")
     */
    public function deleteNews(News $news): Response
    {
        try{
            $news->setIsDeleted(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();
        }catch (\Exception $e){
            return new JsonResponse(['status'=>0, 'mes'=> 'Impossible de supprimer la news']);
        }
        return new JsonResponse(['status'=>1, 'mes'=> 'News supprimée avec succès']);
    }

    /**
     * @Route("/blog/edit", name="edit_news")
     */
    public function editNews(Request $request){
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $title = $request->request->get('title');
        $metaDescription = $request->request->get('metaDescription');
        $content = $request->request->get('content');
        $category = $request->request->get('category');
        $image = $request->files->get("image");

        $isEditing = ($id || $id > 0);

        if($title == '' || $title == null)
            return new JsonResponse(['status'=>0, 'mes'=> 'Renseignez le titre de la news']);

        if($content == '' || $content == null)
            return new JsonResponse(['status'=>0, 'mes'=> 'Renseignez du contenu à la news']);

        if($metaDescription == '' || $metaDescription == null)
            return new JsonResponse(['status'=>0, 'mes'=> 'Renseignez la meta description de la news']);

        if(strlen($metaDescription) > 255)
            return new JsonResponse(['status'=>0, 'mes'=> 'La meta description ne doit pas depasser 255 caractères']);

        if($image == null && !$isEditing)
            return new JsonResponse(['status'=>0, 'mes'=> 'Ajoutez une image à la news']);

        $category = $em->getRepository(Category::class)->find($category);
        if(!$category)
            return new JsonResponse(['status'=>0, 'mes'=> 'Catégorie introuvable']);

        $news = !$isEditing ? new News() : $em->getRepository(News::class)->find($id);
        $news->setTitle($title);
        $news->setContent($content);
        $news->setMetaDescription($metaDescription);
        $news->setCategory($category);

        try{
            if($image != null || $image!=''){
                $fileName = $this->uploadImage($image, $request);
                $result = Thumbnails::createThumbnail($this->getParameter("thumbnails_blog_directory").$fileName,
                    $this->getParameter("images_blog_directory").$fileName, 300);
                if(!$result)
                    return new JsonResponse(['status'=>0, 'mes'=> "Erreur lors de la création de la miniature. Reessayez"]);
                if($isEditing){
                    unlink($this->getParameter('images_blog_directory').$news->getImage());
                    unlink($this->getParameter('thumbnails_blog_directory').$news->getImage());
                }
                $news->setImage($fileName);
            }
        }catch (\Exception $e){
            return new JsonResponse(['status'=>0, 'mes'=> $e->getMessage()]);
        }
        $news->setUser($this->getUser());
        $em->persist($news);
        $em->flush();

        return new JsonResponse(['status'=>1, 'mes'=> !$isEditing ? 'News ajoutée avec succès' : 'News modifiée avec succès']);
    }

    /**
     * @param UploadedFile $file
     * @throws \Exception
     */
    private function uploadImage(UploadedFile $file, Request $request) {
        $imageAccepted = array("jpg", "png", "jpeg");
        if( in_array(strtolower($file->guessExtension()), $imageAccepted) ){
            $fileName = $this->getUniqueFileName().".".$file->guessExtension();
            $file->move($this->getParameter("images_blog_directory"), $fileName);
            return $fileName;
        }else{
            throw new \Exception("Format d'image incorrect", 100);
        }
    }

    private function getUniqueFileName(){
        return md5(uniqid());
    }
}