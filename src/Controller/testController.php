<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class testController extends AbstractController
{

    /**
     * @Route("/test/register", name="test_register_index")
     */
    public function index(UserPasswordEncoderInterface $password, EntityManagerInterface $manager)
    {

        $user = new User();
        $user->setEmail('admin@admin.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($password->encodePassword($user, 'admin'));
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute("index");
    }
}
