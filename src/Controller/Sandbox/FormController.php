<?php

namespace App\Controller\Sandbox;

use App\Entity\Sandbox\Critique;
use App\Entity\Sandbox\Film;
use App\Form\Sandbox\CritiqueType;
use App\Form\Sandbox\FilmType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/sandbox/form', name: 'sandbox_form')]
class FormController extends AbstractController
{
    #[Route(
        '/film/edit/{id}',
        name: '_film_edit',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function filmEditAction(int $id, EntityManagerInterface $em): Response
    {
        $filmRepository = $em->getRepository(Film::class);
        $film = $filmRepository->find($id);

        if (is_null($film))
            throw new NotFoundHttpException('film ' . $id . ' inexistant');

        $form = $this->createForm(FilmType::class, $film);
        $form->add('send', SubmitType::class, ['label' => 'edit film']);

        $args = array(
            'myform' => $form->createView(),
        );

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

    #[Route('/film/validator', name: '_film_validator')]
    public function filmValidatorAction(ValidatorInterface $validator): Response
    {
        $film = new Film();
        $film
            ->setTitre(str_repeat('abc', 100))      // trop de caractères
            ->setAnnee(1849)                        // année trop petite
            ->setEnstock(true)
            ->setPrix(0.99)                         // prix trop faible
            ->setQuantite(-15)                      // incohérent avec enstock (callback), quantité négative
        ;
        dump($validator->validate($film));
        return new Response('<body>cf. dump</body>');
    }

    #[Route('/film/add', name: '_film_add')]
    public function filmAddAction(EntityManagerInterface $em, Request $request): Response
    {
        $film = new Film();

        $form = $this->createForm(FilmType::class, $film);
        $form->add('send', SubmitType::class, ['label' => 'add film']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($film);
            $em->flush();
            $this->addFlash('info', 'ajout film réussi');
            return $this->redirectToRoute('sandbox_doctrine_critique_view2', ['id' => $film->getId()]);
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire ajout film incorrect');

        $args = array(
            'myform' => $form->createView(),
        );
        return $this->render('Sandbox/Form/film_add.html.twig', $args);
    }

    #[Route('/critique/add', name: '_critique_add')]
    public function critiqueAddAction(EntityManagerInterface $em, Request $request): Response
    {
        $critique = new Critique();

        $form = $this->createForm(CritiqueType::class, $critique);
        $form->add('send', SubmitType::class, ['label' => 'add critique']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($critique);
            $em->flush();
            $this->addFlash('info', 'ajout critique réussi');
            return $this->redirectToRoute('sandbox_doctrine_critique_view2', ['id' => $critique->getFilm()->getId()]);
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire ajout critique incorrect');

        $args = array(
            'myform' => $form->createView(),
        );
        return $this->render('Sandbox/Form/critique_add.html.twig', $args);
    }
}
