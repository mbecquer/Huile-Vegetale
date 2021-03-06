<?php

namespace App\Controller\Admin;

use App\Entity\Family;
use App\Entity\Huiles;
use App\Entity\Images;
use App\Form\HuilesType;
use App\Repository\FamilyRepository;
use App\Repository\HuilesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminHuilesController extends AbstractController
{
    private $huilesRepository;
    private $em;
    public function __construct(HuilesRepository $huilesRepository, EntityManagerInterface $em, FamilyRepository $familyRepository)
    {
        $this->huilesRepository = $huilesRepository;
        $this->familyRepository = $familyRepository;
        $this->em = $em;
    }
    /**
     * @Route("/admin", name="admin_huiles_index")
     */
    public function index()
    {



        $family = $this->familyRepository->findAll();
        $huile = $this->huilesRepository->findBy(['family' => $family]);
     
        return $this->render('admin/huiles/index.html.twig', [
            "huiles" => $huile,
            "families" => $family,
        ]);
    }

    /**
     * @Route("/admin/create", name="admin_huiles_create")
     */
    public function create(Request $request, FamilyRepository $familyRepository)
    {
        $families = $familyRepository->findAll();
        $huile = new Huiles();
        $huile->setCreatedAt(new \DateTime());
        $form = $this->createForm(HuilesType::class, $huile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //on récupère les images transmises
            $images = $form->get('images')->getData();
            //on boucle sur les images

            foreach ($images as $image) {
                # code...
                //on génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                //on copie le fichier dans le dossier upload
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                //on stocke l'image dans la base de données (son nom)
                $img = new Images();
                $img->setName($fichier);
                $huile->addImage($img);
            }

            $this->em->persist($huile);
            $this->addFlash("success", "Huile ajoutée avec succès");
            $this->em->flush();
            return $this->redirectToRoute("admin_huiles_index");
        }

        return $this->render("admin/huiles/create.html.twig", [
            "form" => $form->createView(),
            'families' => $families
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="admin_huiles_edit")
     */
    public function edit(Huiles $huile, Request $request, FamilyRepository $familyRepository)
    {
        $families = $familyRepository->findAll();
        $form = $this->createForm(HuilesType::class, $huile);
        $huile->setCreatedAt(new \DateTime());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère les images transmises
            //on récupère les images transmises
            $images = $form->get('images')->getData();
            //on boucle sur les images

            foreach ($images as $image) {
                # code...
                //on génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                //on copie le fichier dans le dossier upload
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                //on stocke l'image dans la base de données (son nom)
                $img = new Images();
                $img->setName($fichier);
                $huile->addImage($img);
            }



            $this->addFlash("success", "Huile modifiée avec succès");
            $this->em->flush();
            return $this->redirectToRoute("admin_huiles_index");
        }
        return $this->render('admin/huiles/edit.html.twig', [
            "form" => $form->createView(),
            'huile' => $huile,
            'families' => $families

        ]);
    }
    /**
     * @Route("/admin/delete/{id}", name="admin_huiles_delete", methods={"DELETE"})
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
    /**
     *  @Route("/admin/huile/delete/image/{id}", name="huile_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Images $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        //on vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
            //on récupère le nom de l'image
            $nom = $image->getName();
            //on supprime le fichier
            unlink($this->getParameter('images_directory') . '/' . $nom);
            //on supprime l'image de la base de données
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
            $this->addFlash("success", "Image supprimée avec succès");
            //on répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token  invalide'], 400);
        };
    }
    /**
     * @Route("/admin/activer/{id}", name="active")
     */
    public function active(Huiles $huile)
    {
        $huile->setActive(($huile->getActive()) ? false : true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($huile);
        $em->flush();

        return new Response("true");
    }
    /**
     * Undocumented function
     *@Route("/admin/activer/family/{id}", name="activeFamily")
     */
    public function activeFamily(Family $family)
    {
        $family->setActive(($family->getActive()) ? false : true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($family);
        $em->flush();

        return new Response("true");
    }
}
