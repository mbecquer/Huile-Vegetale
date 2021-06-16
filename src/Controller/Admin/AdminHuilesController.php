<?php

namespace App\Controller\Admin;

use App\Entity\Huiles;
use App\Form\HuilesType;
use App\Repository\HuilesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

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
            $this->addFlash("success", "Huile ajoutée avec succès");
            $this->em->flush();
            return $this->redirectToRoute("admin_huiles_index");
        }

        return $this->render("admin/huiles/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="admin_huiles_edit")
     */
    public function edit(Huiles $huile, Request $request, CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {

        $form = $this->createForm(HuilesType::class, $huile);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($huile->getImageFile() instanceof UploadedFile) {
                $cacheManager->remove($uploaderHelper->asset($huile, 'imageFile'));
            }

            $this->addFlash("success", "Huile modifiée avec succès");
            $this->em->flush();
            return $this->redirectToRoute("admin_huiles_index");
        }
        return $this->render('admin/huiles/edit.html.twig', [
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/delete/{id}", name="admin_huiles_delete", methods="DELETE")
     */
    public function delete(Huiles $huile, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $huile->getId(), $request->get('_token'))) {
            $this->em->remove($huile);
            $this->em->flush();
            $this->addFlash("success", "Huile supprimée avec succès");
            return $this->redirectToRoute('admin_huiles_index');
        };
    }
}
