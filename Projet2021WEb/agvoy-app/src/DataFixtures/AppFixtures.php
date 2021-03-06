<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Region;
use App\Entity\Room;
use App\Entity\Owner;
class AppFixtures extends Fixture
{
    public const IDF_REGION_REFERENCE = 'idf-region';
    
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $owner= new Owner();
        $owner->setName("janna");
        $owner->setFamilyName("Abedalsater");
      $owner->setAddress("versaille");
       $owner->setCountry("paris");
        
        $manager->persist($owner);
        
        $manager->flush();
        
        $owner= new Owner();
        $owner->setName("oliver");
        $owner->setFamilyName("php");
        $owner->setAddress("versaille");
        $owner->setCountry("paris");
        
        $manager->persist($owner);
        
        $manager->flush();
        
        $ownerId=$owner->getId();
        //1ere region
        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Ile de France");
        $region->setPresentation("La région française capitale");
        $manager->persist($region);
        
        $manager->flush();
        // Une fois l'instance de Region sauvée en base de données,
        // elle dispose d'un identifiant généré par Doctrine, et peut
        // donc être sauvegardée comme future référence.
        $this->addReference(self::IDF_REGION_REFERENCE, $region);
        
        
        
        
        
        
        // ...
        
        $room = new Room();
        $room->setSummary("Beau poulailler ancien à Évry");
        $room->setDescription("très joli espace sur paille");
        $room->setCapacity('3');
        $room->setAddress("versaille");
        $room->setPrice("100");
       // $room->setImageFile('/Projet2021WEb/agvoy-app/public/images/rooms/1.jpeg');
        $room->setSuperficy('50.2');
        
        $room->setOwner($owner);
        //$room->addRegion($region);
        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
       $room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
       $manager->persist($room);
       $manager->flush();
       
       //2eme room
       $imgsrc ="/Projet2021WEb/agvoy-app/public/images/rooms/1.jpeg";
       $room = new Room();
       $room->setSummary("Beau poulailler ancien à versaille");
       $room->setDescription("très joli espace proche a paris");
       $room->setCapacity('4');
       $room->setAddress("versaille");
       $room->setPrice("200");
       $room->setSuperficy('60.5');

       $room->setOwner($owner);
       //$room->addRegion($region);
       // On peut plutôt faire une référence explicite à la référence
       // enregistrée précédamment, ce qui permet d'éviter de se
       // tromper d'instance de Region :
       $room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
       $manager->persist($room);
       $manager->flush();
       
       
    }
}
