<?php

namespace App\Controller\Sandbox;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OverviewController extends AbstractController
{

    #[Route('/sandbox/overview', name: 'sandbox_overview')]
    public function indexAction(): Response
    {
        return new Response('<body>Hello world !</body>');
    }

    #[Route('/sandbox/overview/hello2', name: 'sandbox_overview_hello2')]
    public function hello2Action(): Response
    {
        return $this->render('Sandbox/Overview/hello2.html.twig');
    }

    #[Route('/sandbox/overview/hello3', name: 'sandbox_overview_hello3')]
    public function hello3Action(): Response
    {
        $args = array(
            'prenom' => 'Emilie',
            'jeux' => ['A Plague Tale : Innocence', 'WoW', 'Mass Effect', 'Life is Strange'],
        );
        return $this->render('Sandbox/Overview/hello3.html.twig', $args);

        //Attention
        //ce n’est pas le tableau $args qui est passée en paramètre à la vue mais ses cases.
        // Autrement dit la vue ne reçoit pas un tableau mais deux variables indépendantes
        // nommées dans notre cas prenom et jeux
    }

    #[Route('/sandbox/overview/hello4', name: 'sandbox_overview_hello4')]
    public function hello4Action(): Response
    {
        $args = array(
            'prenom' => 'Emilie',
            'jeux' => ['A Plague Tale : Innocence', 'WoW', 'Mass Effect', 'Life is Strange'],
        );
        return $this->render('Sandbox/Overview/hello4.html.twig', $args);
    }

    #[Route('/', name: 'accueil_index')]
    public function accueilAction(): Response
    {
        return $this->render('Sandbox/Overview/accueil.html.twig');
    }

}
