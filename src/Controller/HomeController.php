<?php

namespace App\Controller;

use App\Repository\FamilyRepository;
use App\Repository\HuilesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $huilesRepository;
    public function __construct(HuilesRepository $huilesRepository, FamilyRepository $familyRepository)
    {
        $this->huilesRepository = $huilesRepository;
        $this->familyRepository = $familyRepository;
    }
    /**
     * Undocumented function
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render("home/index.html.twig", [
            "title" => "Huiles Végétales KA",
            "image" => "/public/assets/868321CA-CD1B-4D1E-A829-5F07E8325A60.jpeg",
        ]);
    }

    /**
     * Undocumented function
     *@Route("/huiles", name="oils")
     */
    public function oils()
    {
        $family = $this->familyRepository->findAll();
        $huile = $this->huilesRepository->findBy(['family' => $family]);

        return $this->render("home/vegetaloils.html.twig", [
            "title" => "Nos Huiles",
            "message" => "Méthode de production",
            "families" => $family,
            "huiles" => $huile
        ]);
    }

    /**
     * Undocumented function
     *@Route("/mentions", name="mentions")
     */
    public function mentions(): Response
    {
        return $this->render("home/mentions.html.twig", [
            "title" => "Informations"
        ]);
    }
}
