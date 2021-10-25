<?php

namespace App\Controller\Admin;



use App\Entity\Picture;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPictureController extends AbstractController
{

    /**
     * @Route("/admin/picture/{id}", name="admin_picture_delete", methods={"DELETE"})
     */
    public function delete(Picture $picture, Request $request)
    {
        $huilesId = $picture->getHuiles()->getId();

        if ($this->isCsrfTokenValid('delete' . $picture->getId(), $request->get('_token'))) {
            $nom = $picture->getFilename();
            //on supprime le fichier
            unlink($this->getParameter('images_directory') . '/' . $nom);
            //on supprime l'image de la base de données
            $em = $this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush();
            $this->addFlash("success", "Image supprimée avec succès");
        };

        return $this->redirectToRoute('admin_huiles_index', ['id' => $huilesId]);
    }
}
