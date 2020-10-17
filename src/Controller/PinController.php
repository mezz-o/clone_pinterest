<?php

namespace App\Controller;

use App\Entity\Pin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class PinController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PinRepository $pinRepository, EntityManagerInterface $em): Response
    {

        //New object hardcoded
        // $pin1= New Pin();
        // $pin1->setTitle('Pin 1');
        // $pin1->setDescription('Desc 1');
        // $em->persist($pin1);
        // $em->flush();

        $pins = $pinRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('pin/index.html.twig', compact('pins'));
    }
    /**
     * @Route("/Pin/{id<[0-9]+>}", name="app_pin_show")
     */
    public function show(Pin $pin): Response
    {
       return $this->render('pin/pin.html.twig', compact('pin'));
    }
}
