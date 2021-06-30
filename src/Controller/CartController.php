<?php

namespace App\Controller;


use App\Entity\Huiles;
use App\Repository\HuilesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function cart(SessionInterface $session, HuilesRepository $huilesRepository): Response
    {

        $panier = $session->get('panier', []);

        $panierWithData = [];
        $total = 0;
        foreach ($panier as $id => $quantity) {
            $huile = $huilesRepository->find($id);
            $pictures = $huilesRepository->find($id);
            $panierWithData[] = [
                'huile' =>  $huile,
                'quantity' => $quantity,
                'pictures' => $pictures

            ];
            $total += $huile->getPrice() * $quantity;
        }

        return $this->render('home/cart.html.twig', [
            'panierWithData' => $panierWithData,
            'total' => $total,

        ]);
    }
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $session)
    {

        $panier = $session->get('panier', []);


        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->addFlash("success", "Huile ajoutée au panier");
        $session->set('panier', $panier);

        return $this->redirectToRoute('cart');
    }
    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove(Huiles $huile, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        $id = $huile->getId();
        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }
        $this->addFlash("success", "Huile enlevée du panier");
        $session->set('panier', $panier);

        return $this->redirectToRoute("cart");
    }
    /**
     * @Route("/cart/delete/{id}", name="cart_delete")
     */
    public function delete(Huiles $huile, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $huile->getId();

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        // On sauvegarde dans la session
        $this->addFlash("success", "Huile supprimée du panier");
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart");
    }
    /**
     * @Route("/cart/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("cart");
    }
}
