<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Car;
use App\Entity\CarType;
use App\Entity\Rent;
use App\Entity\User;
use App\Entity\UserGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{

    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager): void
    {

        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword($this->encoderFactory->getEncoder(Admin::class)->encodePassword('admin', null));
        $manager->persist($admin);

        $client_group = new UserGroup();
        $client_group->setTitle('Клиент');
        $manager->persist($client_group);

        $owner_group = new UserGroup();
        $owner_group->setTitle('Владелец');
        $manager->persist($client_group);

        $owner_1 = new User;
        $owner_1->setLastName('Владелец');
        $owner_1->setName('Иван');
        $owner_1->setMiddleName('Иванович');
        $owner_1->setPhone('+7 (999) 999-99-99');
        $owner_1->setUserGroup($owner_group);
        $manager->persist($owner_1);

        $owner_2 = new User;
        $owner_2->setLastName('Владелец');
        $owner_2->setName('Пётр');
        $owner_2->setMiddleName('Петрович');
        $owner_2->setPhone('+7 (999) 999-99-99');
        $owner_2->setUserGroup($owner_group);
        $manager->persist($owner_2);

        $owner_3 = new User;
        $owner_3->setLastName('Владелец');
        $owner_3->setName('Сергей');
        $owner_3->setMiddleName('Сергеевич');
        $owner_3->setPhone('+7 (999) 999-99-99');
        $owner_3->setUserGroup($owner_group);
        $manager->persist($owner_3);

        $owner_4 = new User;
        $owner_4->setLastName('Владелец');
        $owner_4->setName('Василий');
        $owner_4->setMiddleName('Васильевич');
        $owner_4->setPhone('+7 (999) 999-99-99');
        $owner_4->setUserGroup($owner_group);
        $manager->persist($owner_4);


        $client_1 = new User;
        $client_1->setLastName('Клиент');
        $client_1->setName('Василий');
        $client_1->setMiddleName('Васильевич');
        $client_1->setPhone('+7 (999) 999-99-99');
        $client_1->setUserGroup($client_group);
        $manager->persist($client_1);

        $client_2 = new User;
        $client_2->setLastName('Клиент');
        $client_2->setName('Александр');
        $client_2->setMiddleName('Александрович');
        $client_2->setPhone('+7 (999) 999-99-99');
        $client_2->setUserGroup($client_group);
        $manager->persist($client_2);

        $client_3 = new User;
        $client_3->setLastName('Клиент');
        $client_3->setName('Алексей');
        $client_3->setMiddleName('Алексеевич');
        $client_3->setPhone('+7 (999) 999-99-99');
        $client_3->setUserGroup($client_group);
        $manager->persist($client_3);

        $client_4 = new User;
        $client_4->setLastName('Клиент');
        $client_4->setName('Владимир');
        $client_4->setMiddleName('Владимирович');
        $client_4->setPhone('+7 (999) 999-99-99');
        $client_4->setUserGroup($client_group);
        $manager->persist($client_4);


        $carType_1 = new CarType;
        $carType_1->setTitle('Легковые');
        $manager->persist($carType_1);

        $carType_2 = new CarType;
        $carType_2->setTitle('Грузовые');
        $manager->persist($carType_2);

        $carType_3 = new CarType;
        $carType_3->setTitle('Спецтехника');
        $manager->persist($carType_3);


        $car_1 = new Car;
        $car_1->setTitle('Ford Focus 2');
        $car_1->setActive(true);
        $car_1->setCarType($carType_1);
        $car_1->setOwner($owner_1);
        $manager->persist($car_1);

        $car_2 = new Car;
        $car_2->setTitle('Renault Sandero');
        $car_2->setActive(true);
        $car_2->setCarType($carType_1);
        $car_2->setOwner($owner_2);
        $manager->persist($car_2);

        $car_3 = new Car;
        $car_3->setTitle('Opel Astra J');
        $car_3->setActive(true);
        $car_3->setCarType($carType_1);
        $car_3->setOwner($owner_2);
        $manager->persist($car_3);


        $date = new \DateTime();
        $rent_1 = new Rent;
        $rent_1->setCar($car_1);
        $rent_1->setClient($client_2);
        $rent_1->setStartDate($date->setDate(2021,06,06));
        $rent_1->setEndDate($date->setDate(2021,06,12));
        $rent_1->setCost($rent_1->calcCost());
        $manager->persist($rent_1);


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
