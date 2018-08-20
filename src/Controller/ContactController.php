<?php

namespace App\Controller;

use App\Entity\MessagesContactMe;
use App\Form\MessagesContactMeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {
        $message = new MessagesContactMe();
        $form=$this->createForm(MessagesContactMeType::class, $message);
        $form->handleRequest($request);
        $entityManager=$this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($message);
            $entityManager->flush();
            return $this->redirectToRoute('about');
        }
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form'=> $form->createView(),
        ]);
    }
}
