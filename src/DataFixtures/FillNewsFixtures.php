<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Persistence\ObjectManager;

class FillNewsFixtures extends BaseFixtures
{

    function loadData(ObjectManager $manager)
    {
        $this->createMany(News::class, 5, function (News $news){
            $news
                ->setTitle($this->faker->realTextBetween(10, 50))
                ->setText($this->faker->realTextBetween(300, 1000))
                ->setPublishedAt($this->faker->dateTimeBetween('-14 days'));
        });
        $manager->flush();
    }

}
