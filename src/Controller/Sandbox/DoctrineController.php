<?php

namespace App\Controller\Sandbox;

use App\Entity\Sandbox\Film;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sandbox/doctrine', name: 'sandbox_doctrine')]
class DoctrineController extends AbstractController
{
    #[Route('/list', name: '_list')]
    public function listAction(EntityManagerInterface $em): Response
    {
        $filmRepository = $em->getRepository(Film::class);
        $films = $filmRepository->findAll();
        $args = array(
            'films' => $films,
        );
        return $this->render('Sandbox/Doctrine/list.html.twig', $args);
    }

    #[Route(
        '/view/{id}',
        name: '_view',
        requirements: ['id' => '[1-9]\d*'],
    )]
    public function viewAction(int $id, EntityManagerInterface $em): Response
    {
        $filmRepository = $em->getRepository(Film::class);
        $film = $filmRepository->find($id);
        // normalement un $film à null devrait être traité ici (exception par exemple)
        $args = [
            'film' => $film,    // film peut être null, c'est la vue qui gérera
            'id' => $id,        // utile uniquement si le film n'existe pas
        ];
        return $this->render('Sandbox/Doctrine/view.html.twig', $args);
    }

    #[Route(
    '/delete/{id}',
    name: '_delete',
    requirements: ['id' => '[1-9]\d*'],
    )]
    public function deleteAction(int $id, EntityManagerInterface $em): Response
    {
        $filmRepository = $em->getRepository(Film::class);
        $film = $filmRepository->find($id);

        if (is_null($film))
        {
            $this->addFlash('info', 'suppression film ' . $id . ' : échec');
            throw new NotFoundHttpException('film ' . $id . ' inconnu');
        }

        $em->remove($film);      // le paramètre est l'objet et non pas l'id
        $em->flush();
        $this->addFlash('info', 'suppression film ' . $id . ' réussie');

        return $this->redirectToRoute('sandbox_doctrine_list');

    }

    #[Route('/ajouterendur', name: '_ajouterendur')]
    public function ajouterendurAction(EntityManagerInterface $em): Response
    {
        $film = new Film();                     // le film est encore indépendant de Doctrine
        $film
            -> setTitre('Le grand bleu')
            -> setAnnee(1988)
            ->setEnstock(true)          //Inutile : valeur par défaut
            ->setPrix(9.99)
            ->setQuantite(88);
        dump($film);

        $em->persist($film);    // Doctrine devient responsable du film
        $em->flush();           // injection physique dans la BD
        dump($film);

        return $this->redirectToRoute('sandbox_doctrine_view', ['id' => $film->getId()]);
    }

    #[Route('/modifierendur', name: '_modifierendur')]
    public function modifierendurAction(EntityManagerInterface $em): Response
    {
        $id = 2;                        //id en dur
        $filmRepository = $em->getRepository(Film::class);
        $film = $filmRepository->find($id);
        //Normalement, il faut tester si $film est null
        $film
            ->setPrix(15.98)
            ->setQuantite($film->getQuantite() + 10);


        //$em->persist($film);    // inutile, c'est automatique
        $em->flush();             // /!\ Ne pas oublier sinon rien ne se passe

        return $this->redirectToRoute('sandbox_doctrine_view', ['id' => $film->getId()]);
    }

    #[Route('/effacerendur', name: '_effacerendur')]
    public function effacerendurAction(EntityManagerInterface $em): Response
    {
        $id = 3;                        //id en dur
        $filmRepository = $em->getRepository(Film::class);
        $film = $filmRepository->find($id);
        //Normalement, il faut tester si $film est null

        //$em->persist($film);    // inutile, c'est automatique
        $em->remove($film);      // le paramètre est l'objet et non pas l'id
        $em->flush();             // /!\ Ne pas oublier sinon rien ne se passe

        return $this->redirectToRoute('sandbox_doctrine_list');
    }

}
