<?php

namespace App\Controller\Admin;

use App\Entity\Huiles;
use App\Form\HuilesType;
use App\Repository\HuilesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminHuilesController extends AbstractController
{
    private $huilesRepository;
    private $em;
    public function __construct(HuilesRepository $huilesRepository, EntityManagerInterface $em)
    {
        $this->huilesRepository = $huilesRepository;
        $this->em = $em;
    }
    /**
     * @Route("/admin", name="admin_huiles_index")
     */
    public function index()
    {

        $huiles = $this->huilesRepository->findAll();
        return $this->render('admin/huiles/index.html.twig', [
            "huiles" => $huiles
        ]);
    }

    /**
     * @Route("/admin/create", name="admin_huiles_create")
     */
    public function create(Request $request)
    {
        $huile = new Huiles();
        $form = $this->createForm(HuilesType::class, $huile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($huile);
            $this->em->flush();

            return $this->redirectToRoute("admin_huiles_index");
        }

        return $this->render("admin/huiles/create.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
