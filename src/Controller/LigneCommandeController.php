<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LigneCommandeController extends Controller
{
    /**
     * @Route("/ligne/commande", name="ligne_commande")
     */
    public function index()
    {
        return new Response('Welcome to your new controller!');
    }
}
