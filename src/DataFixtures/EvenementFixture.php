<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EvenementFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {


        for ($i=0;$i<50;$i++){
            $date = new \DateTime('@'.strtotime('now'));
            $event = new Evenement();
            $event
                ->setTitre('Mon Event numero' . $i)
                ->setDescription('Petite description')
                ->setVille('ville' . $i)
                ->setAdresse('adresse' . $i)
                ->setPrix(99 . $i)
                ->setDateFin($date)
                ->setDateDeb($date);

            $manager->persist($event);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
