<?php

namespace App\Controller;

use App\Repository\HuilesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    /**
     * Undocumented function
     *@Route("/cart", name="cart")
     */
    public function cart(SessionInterface $session, HuilesRepository $huilesRepository): Response
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'huile' =>  $huilesRepository->find($id),
                'quantity' => $quantity

            ];
        }
        $total = 0;
        foreach ($panierWithData as $item) {
            $totalItem = $item['huile']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }
        return $this->render("home/cart.html.twig", [
            "title" => "Mon panier",
            "items" => $panierWithData,
            "total" => $total
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


        $session->set('panier', $panier);

        return $this->redirectToRoute('cart');
    }
}
