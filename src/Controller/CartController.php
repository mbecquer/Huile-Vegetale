<?php

namespace App\Controller;

use App\Entity\Huiles;
use App\Repository\HuilesRepository;
use App\Repository\PictureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
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

        return $this->render('home/cart.html.twig', [
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

        $this->addFlash("success", "Huile ajoutée au panier");
        $session->set('panier', $panier);

        return $this->redirectToRoute('cart');
    }
    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("cart");
    }
}
