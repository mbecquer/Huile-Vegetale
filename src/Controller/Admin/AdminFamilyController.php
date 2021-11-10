<?php

namespace App\Controller\Admin;

use App\Entity\Family;
use App\Form\FamilyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminFamilyController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/admin/family", name="admin_famille_create")
     */
    public function createFamily(Request $request)
    {
        $family = new Family();

        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($family);
            $this->addFlash("success", "Famille ajoutée avec succès");
            $this->em->flush();
            return $this->redirectToRoute("admin_huiles_index");
        }

        return $this->render('admin/family/create.html.twig', [
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/edit/family/{id}", name="admin_family_edit")
     */
    public function edit(Family $family, Request $request)
    {

        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $this->addFlash("success", "Famille modifiée avec succès");
            $this->em->flush();
            return $this->redirectToRoute("admin_huiles_index");
        }
        return $this->render('admin/family/edit.html.twig', [
            "form" => $form->createView(),
            'family' => $family,
        ]);
    }
    /**
     * @Route("/admin/family/delete/{id}", name="admin_family_delete", methods={"DELETE"})
     */
    public function delete(Family $family, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $family->getId(), $request->get('_token'))) {
            $this->em->remove($family);
            $this->em->flush();
            $this->addFlash("success", "Famille supprimée avec succès");
            return $this->redirectToRoute('admin_huiles_index');
        };
    }
}
