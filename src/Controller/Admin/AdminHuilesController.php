<?php

namespace App\Controller\Admin;

use App\Repository\HuilesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminHuilesController extends AbstractController
{

    /**
     * @Route("/admin", name="admin_huiles_index")
     */
    public function index(HuilesRepository $huilesRepository)
    {

        $huiles = $huilesRepository->findAll();
        return $this->render('admin/huiles/index.html.twig', [
            "huiles" => $huiles
        ]);
    }
}
