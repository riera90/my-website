<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ResumeController extends Controller
{
    /**
     * @Route("/resume", name="resume")
     */
    public function index()
    {
        return $this->render('resume/index.html.twig', [
            'controller_name' => 'ResumeController',
        ]);
    }
}
