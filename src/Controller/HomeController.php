<?php

namespace App\Controller;

use App\Form\HomeType;
use App\Repository\HomeRepository;
use App\Service\Mailer;
use App\Service\Sluggy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Home;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(HomeRepository $homeRepository)
    {
        $homes = $homeRepository->findAll();

        return $this->render('home/index.html.twig', [
            'homes' => $homes,
        ]);
    }

    /**
     * @Route("/show/{slug}", name="show")
     */
    public function show(Home $home)
    {
        return $this->render('home/show.html.twig', [
            'home' => $home,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/nouveau", name="nouveau")
     */
    public function new(Request $request, EntityManagerInterface $entityManager, Sluggy $sluggy): Response
    {
        $home = new Home();
        $form = $this->createForm(HomeType::class, $home);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $home->setSlug($sluggy->slug($home->getName()));

            $entityManager->persist($home);
            $entityManager->flush();

//            $mailer->sendMail("Nouvelle notification", "vincent@vicnent.fr", "notifications", $form->getData());
//
            return $this->redirectToRoute('home');
        }

        return $this->render('home/new.html.twig',
        [
            'form' => $form->createView()
        ]);
    }
}
