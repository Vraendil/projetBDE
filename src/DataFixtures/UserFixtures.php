<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\fr_FR\PhoneNumber;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new PhoneNumber($faker));

        $user = new User();
        $user ->setEmail('admin@admin.com')
            ->setPassword($this->hasher->hashPassword($user, 'admin'))
            ->setFirstName('admin')
            ->setLastName('admin')
            ->setPhone('0203040506')
            ->setCampus($this->getReference('CAMPUS'.$faker->randomNumber(1,10)))
            ->setRoles(['ROLE_ADMIN']);
        $this->addReference('ADMIN', $user);
        $manager->persist($user);


       // $faker->seed(2);




        for ($i = 1; $i <= 10; $i++){
            $user = new User();
            $user ->setEmail( $faker->unique()->Email())
                ->setLastName($faker->lastName())
                ->setFirstName($faker->firstName())
                ->setPassword($this->hasher->hashPassword($user, 'admin'))
                ->setPhone($faker->serviceNumber())
                ->setCampus($this->getReference('CAMPUS'.$faker->randomNumber(1,10)));

            $manager->persist($user);
            $this->addReference('USER' . $i , $user);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CampusFixtures::class];
    }
}
