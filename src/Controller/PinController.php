<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;

class PinController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods="GET")
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
     * @Route("/Pin/{id<[0-9]+>}", name="app_pin_show", methods="GET")
     */
    public function show(Pin $pin): Response
    {
        return $this->render('pin/pin.html.twig', compact('pin'));
    }

    /**
     * @Route("/Pin/Create", name="app_pin_create", methods="GET|POST")
     */
    public function create(Request $req, EntityManagerInterface $em): Response
    {
        $pin = new Pin();
        //Form hardcoded:
        // $form = $this->createFormBuilder($pin)
        //     ->add('title', TextType::class)
        //     ->add('description', TextareaType::class)
        //     ->getForm();

        $form = $this->createForm(PinType::class, $pin);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute("app_home");
        }



        return $this->render('pin/create.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("/pin/edit/{id<[0-9]+>}", name="app_pin_edit", methods="GET|PUT")
     */
    public function edit(Pin $pin, EntityManagerInterface $em, Request $req): Response
    {

        $form = $this->createForm(PinType::class, $pin, ["method" => "PUT"]);


        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute("app_home");
        }

        return $this->render("/pin/edit.html.twig", ['form' => $form->createView(), "pin" => $pin]);
    }

    //Same Route but different method 

    /**
     * @Route("/pin/{id<[0-9]+>}", name="app_pin_delete", methods="DELETE")
     */
    function delete(Request $req, Pin $pin, EntityManagerInterface $em)
    {
        if ($this->isCsrfTokenValid('pin_delete_' . $pin->getId(), $req->request->get('csrf_token'))) {
            $em->remove($pin);
            $em->flush();
        }
        return $this->redirectToRoute("app_home");
    }
}
