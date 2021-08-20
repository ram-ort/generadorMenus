<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TipoplatoController extends AbstractController
{
    /**
     * @Route("/tipoplato", name="tipoplato")
     */
    public function index()
    {
        return $this->render('tipoplato/index.html.twig', [
            'controller_name' => 'TipoplatoController',
        ]);
    }
}
