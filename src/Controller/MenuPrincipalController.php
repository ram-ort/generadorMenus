<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class MenuPrincipalController extends AbstractController
{
    
    /**
     * @Route("/", name="menuPrincipal_index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('menuPrincipal/index.html.twig', [
            'controller_name' => 'MenuPrincipalController',
        ]);
    }
}
