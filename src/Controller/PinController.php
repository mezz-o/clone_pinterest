<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PinController extends AbstractController
{
    /**
     * @Route("/pin", name="pin")
     */
    public function index()
    {
        return $this->render('pin/index.html.twig', [
            'controller_name' => 'PinController',
        ]);
    }
}
