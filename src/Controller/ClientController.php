<?php

namespace App\Controller;

use App\Entity\Client as Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerBuilder as Serializer;
use JMS\Serializer\SerializationContext;

class ClientController extends Controller
{
    /**
     * @Route("/clients/{id}", name="get_client", requirements={"_format": "json"}, defaults={"_format": "json"}, methods={"GET"})
     */
    public function getClientAction(Request $request, Client $client)
    {
        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($client, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));
        return new Response($jsonContent);
    }

    /**
     * @Route("/clients", name="get_clients", requirements={"_format": "json"}, defaults={"_format": "json"}, methods={"GET"})
     */
    public function getClientsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Client::class);

        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($repo->findAll(), 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonContent);
    }

    /**
     * @Route("/clients", name="add_client", requirements={"_format": "json"}, defaults={"_format": "json"}, methods={"POST"})

        {
            "nom" : "nomclient_2",
            "prenom" : "prenomclient_2",
            "ville" : "villeclient_2"
        }
     */
    public function addClientAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();

        $json = $request->getContent();       

        $serializer = Serializer::create()->build();
        $client = $serializer->deserialize($json, "App\Entity\Client", 'json');

        $em->persist($client);
        $em->flush();

        $jsonArticle = $serializer->serialize($client, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonArticle);
    }

    /**
     * @Route("/clients/{id}", name="delete_client", defaults={"_format": "json"}, methods={"DELETE"})
     */
    public function deleteClientAction(Client $client) 
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();

        return new Response("deleted");
    }

    /**
     * @Route("/clients/{id}", name="update_client", requirements={"_format": "json"}, defaults={"_format": "json"}, methods={"PUT"})

        {
            "nom" : "nomclient_2",
            "prenom" : "prenomclient_2",
            "ville" : "villeclient_2"
        }
     */
    public function updateClientAction(Request $request, Client $client) 
    {
        $em = $this->getDoctrine()->getManager();

        if(!$client) return new Response("this client doesn't exist");

        $serializer = Serializer::create()->build();
        $newClient = $serializer->deserialize($request->getContent(), "App\Entity\Client", 'json');

		if($newClient->getNom()) $client->setNom($newClient->getNom());
        if($newClient->getPrenom()) $client->setPrenom($newClient->getPrenom());        
        if($newClient->getVille()) $client->setVille($newClient->getVille());

        $em->flush();

        $jsonClient = $serializer->serialize($client, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonClient);
    }

}
