<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
    $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
    $this->LoadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
    foreach ($this->getUserData() as [$email,$plainPassword,$role]) {
        $user = new User();
        $encodedPassword = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setEmail($email);
        $user->setPassword($encodedPassword);

        $roles = array();
        $roles[] = $role;
        $user->setRoles($roles);

        $manager->persist($user);
    }
    $manager->flush();
    }

    private function getUserData()
    {
    yield ['jana@localhost','jana','ROLE_USER'];
    yield ['oliver@localhost','oliver','ROLE_ADMIN'];

    }
}
