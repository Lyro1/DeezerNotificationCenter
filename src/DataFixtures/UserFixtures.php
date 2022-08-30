<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AppFixtures {

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void {
        $users = [
            $this->createUser("Lewis", "Hamilton"),
            $this->createUser("Sebastian", "Vettel"),
            $this->createUser("Max", "Verstappen")];
        foreach($users as $user) {
            $manager->persist($user);
            $this->userRepository->add($user);
        }
        $manager->flush();
    }

    private function createUser(string $firstname, string $lastname): User {
        $user = new User();
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        return $user;
    }
}
