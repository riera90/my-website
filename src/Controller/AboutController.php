<?php

namespace App\Controller;

use App\Entity\Terminal;
use App\Form\TerminalType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller
{
    /**
     * @Route("/about", name="about")
     */
    public function home(Request $request, SessionInterface $session)
    {
        $phpsessid=$session->getId();
        $entityManager=$this->getDoctrine()->getManager();
        $terminals=$entityManager->getRepository('App:Terminal')->findTerminalByPhpsessid($phpsessid);

        if (count($terminals)==0)
        {
            $terminal = new Terminal();
            $terminal->setPhpsessid($phpsessid);
        }elseif (count($terminals)==1){
            $terminal=$terminals[0];
        }else{
            //todo: remove all except one terminal
        }


        $form = $this->createForm(TerminalType::class, $terminal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $route=$terminal->resolveInput();
            $entityManager->persist($terminal);
            $entityManager->flush();

            if ($route != null){
                switch ($route){
                    case "github";
                        return $this->redirect("https://github.com/riera90");

                    case "linkeding";
                        return $this->redirect("https://www.linkedin.com/in/riera90/");

                    default:
                        return $this->redirect($route);
                }
            }

            return $this->render('about/index.html.twig', [
                'controller_name' => 'AboutController',
                'lines' => $terminal->getLines(),
                'form'=> $form->createView(),
            ]);
        }
        return $this->render('about/index.html.twig', [
            'controller_name' => 'AboutController',
            'lines' => $terminal->getLines(),
            'form'=> $form->createView(),
        ]);
    }


}
