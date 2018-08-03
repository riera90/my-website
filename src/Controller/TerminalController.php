<?php

namespace App\Controller;

use App\Entity\Terminal;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TerminalController extends Controller
{
    /**
     * @Route("/init", name="terminal initialization")
     */
    public function init()
    {
        $terminal = new Terminal();

        $session = $this->get('session');
        $session->start();
        $terminal->setToken($session->getId());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($terminal);
        $entityManager->flush();

        dump($terminal->getToken());

        return $this->redirectToRoute('homepage');
    }
}