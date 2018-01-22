<?php

namespace App\Controller;

use App\Entity\Commande as Commande;
use App\Entity\Client as Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerBuilder as Serializer;
use JMS\Serializer\SerializationContext;

class CommandeController extends Controller
{
    /**
     * @Route("/commandes/{id}", name="get_commande", requirements={"_format": "json"}, methods={"GET"})
     */
    public function getCommandeAction(Request $request, Commande $commande)
    {
        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($article, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));
        return new Response($jsonContent);
    }

    /**
     * @Route("/commandes", name="get_commandes", requirements={"_format": "json"}, methods={"GET"})
     */
    public function getCommandesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Commande::class);

        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($repo->findAll(), 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonContent);
    }

    /**
     * @Route("/commandes", name="add_commande", requirements={"_format": "json"}, methods={"POST"})
     */
    public function addCommandeAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();

        $json = $request->getContent();       

        $serializer = Serializer::create()->build();
        $commande = $serializer->deserialize($json, "App\Entity\Commande", 'json');

        $em->merge($commande);
        $em->flush();

        $jsonCommande = $serializer->serialize($commande, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonCommande);
    }

    /**
     * @Route("/commandes/{id}", name="delete_commande", methods={"DELETE"})
     */
    public function deleteCommandeAction(Commande $commande) 
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();

        return new Response("deleted");
    }

    /**
     * @Route("/commandes/{id}", name="update_commande", requirements={"_format": "json"}, methods={"PUT"})
     */
    public function updateCommandeAction(Request $request, Commande $commande) 
    {
        $em = $this->getDoctrine()->getManager();

        $serializer = Serializer::create()->build();
        $newCommande = $serializer->deserialize($request->getContent(), "App\Entity\Commande", 'json');

        var_dump($newCommande);

        if($newCommande->getDate()) $commande->setDate($newCommande->getDate());
        if($newCommande->getClient()) $commande->setClient($newCommande->getClient());

        $em->flush();

        $jsonCommande = $serializer->serialize($commande, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonCommande);
    }
    
}
