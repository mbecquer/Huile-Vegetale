<?php

namespace App\Controller;

use App\Entity\Huiles;
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
     *@Route("/buy", name="huile_index")
     */
    public function index()
    {

        $properties = $this->huilesRepository->findAll();
        return $this->render("huile/index.html.twig", [
            "title" => "Nos produits",
            "message" => "Nos produits",
            "huiles" => $properties
        ]);
    }
    /**
     * @Route("/huile/{id}",name="huile_read")
     */
    public function read(int $id)
    {
        $huile = $this->huilesRepository->find($id);
        return $this->render('huile/read.html.twig', [
            'huile' => $huile
        ]);
    }
}
