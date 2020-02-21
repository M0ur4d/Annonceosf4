<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnonceRepository as AR;
use App\Repository\CategorieRepository as CR;
use App\Repository\UserRepository as UR;


class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(AR $annRepo, CR $catRepo, UR $userRepo)
    {
        $categories = $catRepo->findAll();
        $users = $userRepo->findAll();

        $regions = $annRepo->distinctVille();

        $annonces = $annRepo->findAll();

        return $this->render('base.html.twig', compact("categories", "users", "annonces", "regions"));

    }

}
