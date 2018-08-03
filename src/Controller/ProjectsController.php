<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjectsController extends Controller
{
    /**
     * @Route("/projects", name="projects")
     */
    public function index()
    {
        return $this->render('projects/index.html.twig', [
            'controller_name' => 'ProjectsController',
        ]);
    }
}
