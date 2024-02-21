<?php

namespace App\Controller\Sandbox;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sandbox/prefix', name: 'sandbox_prefix')]
class PrefixController extends AbstractController{
    #[Route('', name: '')]
    public function indexAction(): Response
    {
        return new Response('<body>Hello world !</body>');
    }

    #[Route('/hello2', name: '_hello2')]
    public function hello2Action(): Response
    {
        return $this->render('Sandbox/Prefix/hello2.html.twig');
    }

    #[Route('/hello3', name: '_hello3')]
    public function hello3Action(): Response
    {
        $args = array(
            'prenom' => 'Emilie',
            'jeux' => ['A Plague Tale : Innocence', 'WoW', 'Mass Effect', 'Life is Strange'],
        );
        return $this->render('Sandbox/Prefix/hello3.html.twig', $args);

        //Attention
        //ce n’est pas le tableau $args qui est passée en paramètre à la vue mais ses cases.
        // Autrement dit la vue ne reçoit pas un tableau mais deux variables indépendantes
        // nommées dans notre cas prenom et jeux
    }

    #[Route('/hello4', name: '_hello4')]
    public function hello4Action(): Response
    {
        $args = array(
            'prenom' => 'Emilie',
            'jeux' => ['Hogwarts Legacy', 'WoW', 'FF XIV', 'Life is Strange'],
        );
        return $this->render('Sandbox/Prefix/hello4.html.twig', $args);
    }

    /*#[Route('/', name: 'accueil_index')]
    public function accueilAction(): Response
    {
        return $this->render('Sandbox/Prefix/accueil.html.twig');
    }*/
}
