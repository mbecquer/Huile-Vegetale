<?php

namespace App\Controller;

use App\Entity\Huiles;
use App\Repository\FamilyRepository;
use App\Repository\HuilesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HuilesController extends AbstractController
{
    private $huilesRepository;
    public function __construct(HuilesRepository $huilesRepository)
    {
        $this->huilesRepository = $huilesRepository;
    }

    /**
     * Undocumented function
     * @Route("/produits", name="huile_index")
     */
    public function index()
    {

        $properties = $this->huilesRepository->findAll();
        return $this->render("huile/index.html.twig", [
            "title" => "Mes produits",
            "message" => "Mes produits",
            "huiles" => $properties
        ]);
    }
    /**
     * @Route("/huile/{slug}-{id}",name="huile_read", requirements={"slug"="[a-z0-9\-]*"})
     */
    public function read(string $slug, int $id)
    {
        $huile = $this->huilesRepository->find($id);
  
        if ($huile->getSlug() !== $slug) {
            $this->redirectToRoute('huile_read', [
                "id" => $huile->getId(),
                "slug" => $huile->getSlug()
            ]);
        }
        return $this->render('huile/read.html.twig', [
            'huile' => $huile,
     
        ]);
    }
}
