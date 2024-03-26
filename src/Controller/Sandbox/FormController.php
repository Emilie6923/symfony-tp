<?php

namespace App\Controller\Sandbox;

use App\Entity\Sandbox\Film;
use App\Form\Sandbox\FilmType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sandbox/form', name: 'sandbox_form')]
class FormController extends AbstractController
{
    #[Route(
        '/film/edit/{id}',
        name: '_film_edit',
        requirements: ['id' => '[1-9]\d*']
    )]
    public function filmEditAction(int $id, EntityManagerInterface $em): Response
    {
        $filmRepository = $em->getRepository(Film::class);
        $film = $filmRepository->find($id);

        if (is_null($film))
            throw new NotFoundHttpException('film '.$id.' inexistant');

        $form = $this->createForm(FilmType::class, $film);
        $form->add('send', SubmitType::class, ['label' => 'edit film']);

        $args = [
            'myform' => $form->createView(),
        ];

        return $this->render('Sandbox/Form/film_edit.html.twig', $args);
    }

    #[Route(
        '/film/editbis/{id}',
        name: '_film_editbis',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function filmEditbisAction(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $filmRepository = $em->getRepository(Film::class);
        $film = $filmRepository->find($id);

        if (is_null($film))
            throw new NotFoundHttpException('film ' . $id . ' inexistant');

        $form = $this->createForm(FilmType::class, $film);
        $form->add('send', SubmitType::class, ['label' => 'edit film']);

        //lien entre l'entité et le formulaire (soumis ou non)
        //Si un formulaire est reçu, les données sont recopiées dans $film,
        //en écransant les données lus dans la BDD
        $form->handleRequest($request);

        //Si formulaire reçu et bien rempli
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            $this->addFlash('info', 'édition film réussie');
            return $this->redirectToRoute('sandbox_doctrine_critique_view2', ['id' => $film->getId()]);
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire film incorrect');

        $args = array(
            'myform' => $form->createView(),
        );
        return $this->render('Sandbox/Form/film_editbis.html.twig', $args);
    }

}
