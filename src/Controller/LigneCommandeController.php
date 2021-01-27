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
     * @Route("/ligneCommandes/{id}", name="get_ligneCommand", requirements={"_format": "json"}, defaults={"_format": "json"}, methods={"GET"})
     */
    public function getLigneCommandeAction(Request $request, LigneCommande $lignecommande)
    {
        $serializer = Serializer::create()->build();
        $jsonContent = $serializer->serialize($article, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));
        return new Response($jsonContent);
    }

    /**
     * @Route("/ligneCommandes", name="get_ligneCommandes", requirements={"_format": "json"}, defaults={"_format": "json"}, methods={"GET"})
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
     * @Route("/ligneCommande", name="add_ligneCommande", requirements={"_format": "json"}, defaults={"_format": "json"}, methods={"POST"})

        {
            "commande": {
                "id": 1 
            },
            "article": {
                "id": 9
            },
            "quantite": 10
        }
     */
    public function addLigneCommandeAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();

        $json = $request->getContent();       

        $serializer = Serializer::create()->build();
        $lignecommande = $serializer->deserialize($json, "App\Entity\LigneCommande", 'json');

        $em->merge($lignecommande);
        $em->flush();

        $jsonLigneCommande = $serializer->serialize($lignecommande, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonLigneCommande);
    }

    /**
     * @Route("/ligneCommande/{id}", name="delete_ligneCommande", defaults={"_format": "json"}, methods={"DELETE"})
     */
    public function deleteLigneCommandeAction(LigneCommande $lignecommande) 
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($lignecommande);
        $em->flush();

        return new Response("deleted");
    }

    /**
     * @Route("/ligneCommande/{id}", name="update_ligneCommande", requirements={"_format": "json"}, defaults={"_format": "json"}, methods={"PUT"})

        {
            "article": {
                "id": 10
            },
            "quantite": 10
        }
     */
    public function updateLigneCommandeAction(Request $request, LigneCommande $lignecommande) 
    {
        $em = $this->getDoctrine()->getManager();

        $repoArticle = $em->getRepository(Article::class);
        $repoCommande = $em->getRepository(Commande::class);

        $serializer = Serializer::create()->build();
        $newLigneCommande = $serializer->deserialize($request->getContent(), "App\Entity\LigneCommande", 'json');

        if($newLigneCommande->getQuantite()) $lignecommande->setQuantite($newLigneCommande->getQuantite());
        if($newLigneCommande->getArticle()) 
        {
            $article = $repoArticle->find($newLigneCommande->getArticle()->getId());
            $lignecommande->setArticle($article);
        }
        if($newLigneCommande->getCommande()) 
        {
            $commande = $repoCommande->find($newLigneCommande->getCommande()->getId());
            $lignecommande->setCommande($commande);
        } 

        $em->flush();

        $jsonLigneCommande = $serializer->serialize($lignecommande, 'json'  , SerializationContext::create()->setGroups(array('toSerialize')));

        return new Response($jsonLigneCommande);
    }

}
