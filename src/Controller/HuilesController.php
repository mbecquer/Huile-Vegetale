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
    public function __construct(HuilesRepository $huilesRepository, FamilyRepository $familyRepository)
    {
        $this->huilesRepository = $huilesRepository;
        $this->familyRepository = $familyRepository;
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
     * @Route("/family/{slug}-{id}",name="family_huile", requirements={"slug"="[a-z0-9\-]*"})
     */
    public function family(string $slug, int $id)
    {
        $family = $this->familyRepository->find($id);
        $huile = $this->huilesRepository->findBy(['family' => $family]);
        if ($family->getSlug() !== $slug) {
            $this->redirectToRoute('family_huile', [
                "id" => $family->getId(),
                "slug" => $family->getSlug()
            ]);
        }
        return $this->render('huile/index.html.twig', [
            'huiles' => $huile,
            'family' => $family
        ]);
    }
}
