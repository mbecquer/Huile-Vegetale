<?php

namespace App\Controller;

use App\Repository\HuilesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $huilesRepository;
    public function __construct(HuilesRepository $huilesRepository)
    {
        $this->huilesRepository = $huilesRepository;
    }
    /**
     * Undocumented function
     *@Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render("home/index.html.twig", [
            "title" => "Huiles Végétales KA",
            "image" => "/public/assets/868321CA-CD1B-4D1E-A829-5F07E8325A60.jpeg"
        ]);
    }

    /**
     * Undocumented function
     *@Route("/huiles", name="huiles")
     */
    public function huiles(): Response
    {
        $properties = $this->huilesRepository->findAll();
        return $this->render("home/huiles.html.twig", [
            "title" => "Nos Huiles",
            "message" => "Nos Huiles",
            "huiles" => $properties
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
