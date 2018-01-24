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

        {
            "article": {
                "id": 10
            },
            "date_debut": "2018-01-24 13:08:26",
            "date_fin": "2018-02-10",
            "pourcentage": 50
        }
     */
    public function addPromotionAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();

        $json = $request->getContent();       

        $serializer = Serializer::create()->build();
        $promotion = $serializer->deserialize($json, "App\Entity\Promotion", 'json');
        
        $em->merge($promotion);
        $em->flush();

        $jsonPromotion = $serializer->serialize($promotion, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonPromotion);
    }

    /**
     * @Route("/promotions", name="delete_promotion", requirements={"_format": "json"}, methods={"DELETE"})
        
        {
        "article": {
            "id": 10
        },
            "date_debut": "2018-01-24 13:08:26"
        }
     */
    public function deletePromotionAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Promotion::class);

        $serializer = Serializer::create()->build();
        $newPromotion = $serializer->deserialize($request->getContent(), "App\Entity\Promotion", 'json');

        $promotion = $repo->find(array("dateDebut" => $newPromotion->getDateDebut(), "article" => $newPromotion->getArticle()->getId()));

        $em->remove($promotion);
        $em->flush();

        return new Response("deleted");
    }

    /**
     * @Route("/promotions", name="update_promotion", requirements={"_format": "json"}, methods={"PUT"})

        {
            "article": {
                "id": 10
            },
            "date_debut": "2018-01-24 13:08:26",
            "date_fin": "2019-02-10",
            "pourcentage": 70
        }
     */
    public function updatePromotionAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Promotion::class);

        $serializer = Serializer::create()->build();
        $newPromotion = $serializer->deserialize($request->getContent(), "App\Entity\Promotion", 'json');

        $promotion = $repo->find(array("dateDebut" => $newPromotion->getDateDebut(), "article" => $newPromotion->getArticle()->getId()));

        if($newPromotion->getDateFin()) $promotion->setDateFin($newPromotion->getDateFin());
        if($newPromotion->getPourcentage()) $promotion->setPourcentage($newPromotion->getPourcentage());

        $em->flush();

        $jsonPromotion = $serializer->serialize($promotion, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonPromotion);
    }
 
}
