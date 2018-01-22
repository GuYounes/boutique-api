<?php

namespace App\Controller;

use App\Entity\LigneCommande as LigneCommande;
use App\Entity\Article as Article;
use App\Entity\Commande as Commande;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerBuilder as Serializer;
use JMS\Serializer\SerializationContext;

class LigneCommandeController extends Controller
{
    /**
     * @Route("/ligneCommandes/{id}", name="get_ligneCommand", requirements={"_format": "json"}, methods={"GET"})
     */
    public function getLigneCommandeAction(Request $request, LigneCommande $lignecommande)
    {
        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($article, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));
        return new Response($jsonContent);
    }

    /**
     * @Route("/ligneCommandes", name="get_ligneCommandes", requirements={"_format": "json"}, methods={"GET"})
     */
    public function getLigneCommandesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(LigneCommande::class);

        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($repo->findAll(), 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonContent);
    }

    /**
     * @Route("/ligneCommande", name="add_ligneCommande", requirements={"_format": "json"}, methods={"POST"})
     */
    public function addLigneCommandeAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();
        $repoCommande = $em->getRepository(Commande::class);
        
        // categorie non donné par le json pour le moment
        $commande = $repoCommande->find(1);

        $repoArticle = $em->getRepository(ARticle::class);
        
        // categorie non donné par le json pour le moment
        $article = $repoArticle->find(1);

        $json = $request->getContent();       

        $serializer = Serializer::create()->build();
        $lignecommande = $serializer->deserialize($json, "App\Entity\LigneCommande", 'json');

        $lignecommande->setCommande($commande);
        $lignecommande->setArticle($article);

        $em->persist($lignecommande);
        $em->flush();

        $jsonLigneCommande = $serializer->serialize($lignecommande, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonLigneCommande);
    }

    /**
     * @Route("/ligneCommande/{id}", name="delete_ligneCommande", methods={"DELETE"})
     */
    public function deleteLigneCommandeAction(LigneCommande $lignecommande) 
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($lignecommande);
        $em->flush();

        return new Response("deleted");
    }

    /**
     * @Route("/ligneCommande/{id}", name="update_ligneCommande", requirements={"_format": "json"}, methods={"PUT"})
     */
    public function updateLigneCommandeAction(Request $request, LigneCommande $lignecommande) 
    {
        $em = $this->getDoctrine()->getManager();

        if(!$lignecommande) return new Response("this lignecommande doesn't exist");

        $serializer = Serializer::create()->build();
        $newLigneCommande = $serializer->deserialize($request->getContent(), "App\Entity\LigneCommande", 'json');

        if($newLigneCommande->getQuantite()) $article->setQuantite($newLigneCommande->getQuantite());
        if($newLigneCommande->getArticle()) $article->setArticle($newLigneCommande->getArticle());
        if($newLigneCommande->getCommande()) $article->setCommande($newLigneCommande->getCommande());

        $em->flush();

        $jsonLigneCommande = $serializer->serialize($lignecommande, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonLigneCommande);
    }

}
