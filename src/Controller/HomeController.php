<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\FamilyRepository;
use App\Repository\HuilesRepository;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $huilesRepository;
    public function __construct(HuilesRepository $huilesRepository, FamilyRepository $familyRepository)
    {
        $this->huilesRepository = $huilesRepository;
        $this->familyRepository = $familyRepository;
    }
    /**
     * Undocumented function
     * @Route("/", name="index")
     */
    public function index(Request $request, ContactNotification $notification): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);
            $this->addFlash('success', 'Email envoyé avec succès');
            return $this->redirectToRoute('index');
        }
        return $this->render("home/index.html.twig", [
            "title" => "Huiles Végétales KA",
            "image" => "/public/assets/868321CA-CD1B-4D1E-A829-5F07E8325A60.jpeg",
            'form' => $form->createView(),
        ]);
    }

    /**
     * Undocumented function
     *@Route("/huiles", name="oils")
     */
    public function oils()
    {
        $family = $this->familyRepository->findAll();
        $huile = $this->huilesRepository->findBy(['family' => $family]);
        return $this->render("home/vegetaloils.html.twig", [
            "title" => "Nos Huiles",
            "families" => $family,
            "huiles" => $huile,

        ]);
    }

    /**
     * Undocumented function
     *@Route("/mentions", name="mentions")
     */
    public function mentions(): Response
    {
        return $this->render("home/mentions.html.twig", [
            "title" => "Informations"
        ]);
    }
}
