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
    /**
     * @Route("/family/{id}",name="family_huile")
     */
    public function family(int $id, FamilyRepository $familyRepository)
    {
        $family = $familyRepository->find($id);
        $huile = $this->huilesRepository->findBy(['family' => $family]);


        return $this->render('huile/family.html.twig', [
            'huiles' => $huile,
            'family' => $family

        ]);
    }
}
