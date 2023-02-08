<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    //gestion du hash password 
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        //gestion de l'admin

        $admin = new User();

        $admin->setFirstname('Romeo')
              ->setLastname('Wilmart')
              ->setEmail('test@admin.be')
              ->setPassword($this->passwordHasher->hashPassword($admin,'passwordAdmin'))
              ->setRoles(['ROLE_USER']);
        
              $manager->persist($admin);
        $manager->flush();
    
}
}
