<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class testController extends AbstractController
{
    private $password;
    public function __construct(UserPasswordEncoderInterface $password)
    {
        $this->password = $password;
    }
    /**
     * @Route("/test/register", name="test_register_index")
     */
    public function index(EntityManagerInterface $manager)
    {

        $user = new User();
        $user->setEmail('admin@admin.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->password->encodePassword($user, 'admin'));
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute("index");
    }
}
