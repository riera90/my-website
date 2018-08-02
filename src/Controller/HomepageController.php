<?php

namespace App\Controller;

use App\Entity\Terminal;
use App\Form\TerminalType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    /**
     * @Route("/homepage", name="homepage")
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
            $stupidVar=0;
        }

        dump($phpsessid);


        dump($terminals);

        $form = $this->createForm(TerminalType::class, $terminal);
        //dump($terminal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $terminal->addLine($terminal->getInput());
            $entityManager->persist($terminal);
            $entityManager->flush();

            return $this->render('homepage/index.html.twig', [
                'controller_name' => 'HomepageController',
                'lines' => $terminal->getLines(),
                'form'=> $form->createView(),
            ]);
        }
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'lines' => $terminal->getLines(),
            'form'=> $form->createView(),
        ]);
    }


}
