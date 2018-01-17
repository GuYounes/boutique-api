<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\Serializer\SerializerBuilder as Serializer;
use JMS\Serializer\SerializationContext;


class ArticleController extends Controller
{
    /**
     * @Route("/articles/{id}", name="get_article", requirements={"_format": "json"})
     */
    public function getArticleAction(Request $request, Article $article)
    {
        /*$em = $this->getDoctrine()->getManager();*/
        /*$em->flush();*/

        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($article, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));
        return new Response($jsonContent);
    }

    /**
     * @Route("/articles", name="get_articles", requirements={"_format": "json"})
     */
    public function getArticlesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Article::class);

        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($repo->findAll(), 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonContent);
    }


}
