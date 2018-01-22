<?php

namespace App\Controller;

use App\Entity\Categorie as Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerBuilder as Serializer;
use JMS\Serializer\SerializationContext;

class CategorieController extends Controller
{
    /**
     * @Route("/categories/{id}", name="get_categorie", requirements={"_format": "json"}, methods={"GET"})
     */
    public function getCategorieAction(Request $request, Categorie $categorie)
    {
        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($categorie, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));
        return new Response($jsonContent);
    }

    /**
     * @Route("/categories", name="get_categories", requirements={"_format": "json"}, methods={"GET"})
     */
    public function getCategoriesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Categorie::class);

        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($repo->findAll(), 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonContent);
    }

    /**
     * @Route("/categories", name="add_categorie", requirements={"_format": "json"}, methods={"POST"})
     */
    public function addCategorieAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();
        
        $json = $request->getContent();       

        $serializer = Serializer::create()->build();
        $categorie = $serializer->deserialize($json, "App\Entity\Categorie", 'json');

        $em->persist($categorie);
        $em->flush();

        $jsonCategorie = $serializer->serialize($categorie, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonCategorie);
    }

    /**
     * @Route("/categories/{id}", name="delete_categorie", methods={"DELETE"})
     */
    public function deleteCategorieAction(Categorie $categorie) 
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();

        return new Response("deleted");
    }

    /**
     * @Route("/categories/{id}", name="update_categorie", requirements={"_format": "json"}, methods={"PUT"})
     */
    public function updateCategorieAction(Request $request, Categorie $categorie) 
    {
        $em = $this->getDoctrine()->getManager();

        $serializer = Serializer::create()->build();
        $newCategorie = $serializer->deserialize($request->getContent(), "App\Entity\Categorie", 'json');

        if($newCategorie->getNom()) $categorie->setNom($newCategorie->getNom());
        if($newCategorie->getVisuel()) $categorie->setVisuel($newCategorie->getVisuel());   

        $em->flush();

        $jsonCategorie = $serializer->serialize($categorie, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonCategorie);
    }

}
