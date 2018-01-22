<?php

namespace App\Controller;

use App\Entity\Promotion as Promotion;
use App\Entity\Article as Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerBuilder as Serializer;
use JMS\Serializer\SerializationContext;

class PromotionController extends Controller
{
    /**
     * @Route("/promotions/{id}", name="get_promotion", requirements={"_format": "json"}, methods={"GET"})
     */
    public function getPromotionAction(Request $request, Promotion $promotion)
    {
        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($promotion, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));
        return new Response($jsonContent);
    }

    /**
     * @Route("/promotions", name="get_promotions", requirements={"_format": "json"}, methods={"GET"})
     */
    public function getPromotionsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Promotion::class);

        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($repo->findAll(), 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonContent);
    }

    /**
     * @Route("/promotions", name="add_promotion", requirements={"_format": "json"}, methods={"POST"})
     */
    public function addPromotionAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Article::class);
        
        // client non donné par le json pour le moment
        $article = $repo->find(1);

        $json = $request->getContent();       

        $serializer = Serializer::create()->build();
        $promotion = $serializer->deserialize($json, "App\Entity\Promotions", 'json');

        $promotion->setArticle($article);

        $em->persist($promotion);
        $em->flush();

        $jsonPromotion = $serializer->serialize($promotion, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonPromotion);
    }

    /**
     * @Route("/promotions/{id}", name="delete_promotion", methods={"DELETE"})
     */
    public function deletePromotionAction(Promotion $promotion) 
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();

        return new Response("deleted");
    }

    /**
     * @Route("/promotions/{id}", name="update_promotion", requirements={"_format": "json"}, methods={"PUT"})
     */
    public function updatePromotionAction(Request $request, Promotion $promotion) 
    {
        $em = $this->getDoctrine()->getManager();

        if(!$promotion) return new Response("this promotion doesn't exist");

        $serializer = Serializer::create()->build();
        $newPromotion = $serializer->deserialize($request->getContent(), "App\Entity\Promotion", 'json');

        if($newPromotion->getDateDebut()) $promotion->setDateDebut($newPromotion->getDateDebut());
        if($newPromotion->getDateFin()) $promotion->setDateFin($newPromotion->getDateFin());
        if($newPromotion->getPourcentage()) $promotion->setPourcentage($newPromotion->getPourcentage());
        if($newPromotion->getArticle()) $promotion->setArticle($newPromotion->getArticle());

        $em->flush();

        $jsonPromotion = $serializer->serialize($promotion, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonPromotion);
    }
 
}
