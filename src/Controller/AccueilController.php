<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnonceRepository as AR;
use App\Repository\CategorieRepository as CR;
use App\Repository\UserRepository as UR;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


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

    /**
     * @Route("/admin/", name="accueil_admin")
     * @IsGranted("ROLE_ADMIN")

     */
    public function index_admin(AR $annRepo, CR $catRepo, UR $userRepo)
    {
        $categories = $catRepo->findAll();
        $users = $userRepo->findAll();

        $regions = $annRepo->distinctVille();

        $annonces = $annRepo->findAll();

        return $this->render('admin_base.html.twig', compact("categories", "users", "annonces", "regions"));

    }

}
