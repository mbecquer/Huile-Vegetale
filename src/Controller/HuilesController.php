<?php

namespace App\Controller;

use App\Entity\Huiles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HuilesController extends AbstractController
{
    /**
     * Undocumented function
     *@Route("/buy", name="huile_index")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Huiles::class);
        $properties = $repository->findAll();

        // $huile = new Huiles();
        // $huile->setName("ma première huile")
        //     ->setDescription("ma super huile alimentaire")
        //     ->setCapacity(50)
        //     ->setPrice(15.50)
        //     ->setImage("/public/assets/oil.jpg");
        // $em =  $this->getDoctrine()->getManager();
        // $em->persist($huile);
        // $em->flush();

        return $this->render("huile/index.html.twig", [
            "title" => "Nos produits",
            "message" => "Nos nouveautés",
            "huiles" => $properties
        ]);
    }
}
