<?php

namespace App\Controller;

use App\Entity\Article as Article;
use App\Entity\Categorie as Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\Serializer\SerializerBuilder as Serializer;
use JMS\Serializer\SerializationContext;


class ArticleController extends Controller
{
    /**
     * @Route("/articles/{id}", name="get_article", requirements={"_format": "json"}, methods={"GET"})
     */
    public function getArticleAction(Request $request, Article $article)
    {
        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($article, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));
        return new Response($jsonContent);
    }

    /**
     * @Route("/articles", name="get_articles", requirements={"_format": "json"}, methods={"GET"})
     */
    public function getArticlesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Article::class);

        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($repo->findAll(), 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonContent);
    }

    /**
     * @Route("/articles", name="add_article", requirements={"_format": "json"}, methods={"POST"})
     */
    public function addArticleAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();

        $json = $request->getContent();       

        $serializer = Serializer::create()->build();
        $article = $serializer->deserialize($json, "App\Entity\Article", 'json');

        $em->merge($article);
        $em->flush();

        $jsonArticle = $serializer->serialize($article, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonArticle);
    }

    /**
     * @Route("/articles/{id}", name="delete_article", methods={"DELETE"})
     */
    public function deleteArticleAction(Article $article) 
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return new Response("deleted");
    }

    /**
     * @Route("/articles/{id}", name="update_article", requirements={"_format": "json"}, methods={"PUT"})
     */
    public function updateArticleAction(Request $request, Article $article) 
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Categorie::class);

        $serializer = Serializer::create()->build();
        $newArticle = $serializer->deserialize($request->getContent(), "App\Entity\Article", 'json');

        if($newArticle->getReference()) $article->setReference($newArticle->getReference());
        if($newArticle->getNom()) $article->setNom($newArticle->getNom());
        if($newArticle->getTarif()) $article->setTarif($newArticle->getTarif());
        if($newArticle->getVisuel()) $article->setVisuel($newArticle->getVisuel());
        if($newArticle->getCategorie()) 
        {
            $categorie = $repo->find($newArticle->getCategorie()->getId());
            $article->setCategorie($categorie);
        }
        
        $em->flush();

        $jsonArticle = $serializer->serialize($article, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonArticle);
    }

}
