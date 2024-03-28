<?php

namespace App\DataFixtures;

use App\Entity\Manuel;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VenteFixtures extends Fixture
{
    public function load(ObjectManager $em): void
    {
        $produit1 = new Produit();
        $produit1
            ->setDenomination('voiture')
            ->setCode('7 11 654 876')
            ->setDateCreation(new \DateTime())
            ->setActif(true)
            ->setDescriptif('descriptif 11111');
        $em->persist($produit1);

        $manuel2 = new Manuel();
        $manuel2
            ->setUrl('http://aaaaa')
            ->setSommaire('I titre; II pas titre');
        $em->persist($manuel2);

        $produit2 = new Produit();
        $produit2
            ->setDenomination('skate')
            ->setCode('5 21 749 559')
            ->setDateCreation(new \DateTime())
            ->setActif(true)
            ->setDescriptif('descriptif 22222');
        // il faudra ici associer le manuel2 au produit2
        $em->persist($produit2);


        $produit3 = new Produit();
        $produit3
            ->setDenomination('vélo')
            ->setCode('2 45 814 445')
            ->setDateCreation(new \DateTime())
            ->setActif(false)
            ->setDescriptif('descriptif 33333');
        $em->persist($produit3);


        $manuel4 = new Manuel();
        $manuel4
            ->setUrl('http://bbbb')
            ->setSommaire(null);
        $em->persist($manuel4);

        $produit4 = new Produit();
        $produit4
            ->setDenomination('avion')
            ->setCode('8 44 783 712')
            ->setDateCreation(new \DateTime())
            ->setActif(true)
            ->setDescriptif('descriptif 44444');
        // il faudra ici associer le manuel4 au produit4
        $em->persist($produit4);


        $em->flush();
    }
}
