<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * Undocumented function
     *@Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render("home/index.html.twig", [
            "title" => "Huiles Végétales KA",
            "image" => "/public/assets/868321CA-CD1B-4D1E-A829-5F07E8325A60.jpeg"
        ]);
    }

    /**
     * Undocumented function
     *@Route("/huiles", name="huiles")
     */
    public function huiles(): Response
    {

        return $this->render("home/huiles.html.twig", [
            "title" => "Nos Huiles",
            "message" => "Nos Huiles"
        ]);
    }

    /**
     * Undocumented function
     *@Route("/mentions", name="mentions")
     */
    public function mentions(): Response
    {

        return $this->render("home/mentions.html.twig", [
            "title" => "Mentions légales"
        ]);
    }
}
