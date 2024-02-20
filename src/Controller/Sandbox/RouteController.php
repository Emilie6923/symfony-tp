<?php

namespace App\Controller\Sandbox;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sandbox/route', name: 'sandbox_route')]
class RouteController extends AbstractController{

    #[Route('', name: '')]
    public function indexAction(): Response
    {
        return new Response('<body>RouteController</body>');
    }

    // /!\ ROUTE sur plusieurs lignes : utile quand il y en aura plus
    #[Route(
        '/with-variable/{age}',
        name: '_with_variable',
    )]
    public function withVariableAction($age): Response
    {
        return new Response('<body>Route::withVariable : age = ' . $age . '</body>');
    }

    #[Route(
        '/with-default/{age}',
        name: '_with_default',
        defaults: ['age' => 18],
    )]
    public function withDefaultAction($age): Response
    {
        dump($age);
        return new Response('<body>Route::withDefault : age = ' . $age . ' (' . gettype($age) . ')</body>');
    }

    #[Route(
        '/with-constraint/{age}',
        name: '_with_constraint',
        //Plus on bloque de cas, moins il y aura de tests à faire
        requirements: ['age' => '0|[1-9]\d*'],
        defaults: ['age' => 18],
    )]
    public function withConstraintAction(int $age): Response
    {
        dump($age);
        return new Response('<body>Route::withConstraint : age = ' . $age . ' (' . gettype($age) . ')</body>');
    }

    #[Route(
        '/test1/{year}/{month}/{filename}.{ext}',
        name : '_test1',
    )]
    public function test1Action($year, $month, $filename, $ext): Response{
        $args = [
            'title'     => 'test1',
            'year'      => $year,
            'month'     => $month,
            'filename'  => $filename,
            'ext'       => $ext
        ];
        return $this->render('Sandbox/Route/test1234.html.twig', $args);
    }

    #[Route(
        '/test2/{year}/{month}/{filename}.{ext}',
        name : '_test2',
        requirements: [
                'year'      => '[1-9]\d{0,3}',
                'month'     => '(0?[1-9])|(1[0-2])',
                'filename'  => '[-a-zA-Z]+',
                'ext'       => 'jpg|jpeg|png|ppm'
            ],
    )]
    public function test2Action(int $year, int $month, string $filename, string$ext): Response{
        $args = [
            'title'     => 'test2',
            'year'      => $year,
            'month'     => $month,
            'filename'  => $filename,
            'ext'       => $ext
        ];
        return $this->render('Sandbox/Route/test1234.html.twig', $args);
    }

    #[Route(
        '/test3/{year}/{month}/{filename}.{ext}',
        name : '_test3',
        requirements: [
            'year'      => '[1-9]\d{0,3}',
            'month'     => '(0?[1-9])|(1[0-2])',
            'filename'  => '[-a-zA-Z]+',
            'ext'       => 'jpg|jpeg|png|ppm'
        ],
        defaults: ['ext' => 'png'],
    )]
    public function test3Action(int $year, int $month, string $filename, string $ext): Response{
        $args = [
            'title'     => 'test3',
            'year'      => $year,
            'month'     => $month,
            'filename'  => $filename,
            'ext'       => $ext
        ];
        return $this->render('Sandbox/Route/test1234.html.twig', $args);
    }

    #[Route(
        '/test4/{year}/{month}/{filename}.{ext}',
        name : '_test4',
        requirements: [
            'year'      => '[1-9]\d{0,3}',
            'month'     => '(0?[1-9])|(1[0-2])',
            'filename'  => '[-a-zA-Z]+',
            'ext'       => 'jpg|jpeg|png|ppm'],
        defaults: [
                'month' => 1,
                'filename' => 'picture',
                'ext' => 'png'],
    )]
    public function test4Action(int $year, int $month, string $filename, string $ext): Response{
        $args = [
            'title'     => 'test4',
            'year'      => $year,
            'month'     => $month,
            'filename'  => $filename,
            'ext'       => $ext
        ];
        return $this->render('Sandbox/Route/test1234.html.twig', $args);
    }

    //Conflit avec test4Action => L'ordre des fonctions détermine la priorité
    #[Route(
        '/test4/{year}',
        name: '_test4bis',
        requirements: [
            'year' => '[1-9]\d{0,3}',
        ],
    )]
    public function test4bisAction(int $year): Response
    {
        $args =  [
            'title' => 'test4bis',
            'year'  => $year,
        ];
        return $this->render('Sandbox/Route/test4bis.html.twig', $args);
    }

}
