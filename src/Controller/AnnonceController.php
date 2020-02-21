<?php

namespace App\Controller;

use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class AnnonceController extends AbstractController
{
//    /**
//     * @Route("/annonce", name="annonce")
//     */
//    public function index()
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/AnnonceController.php',
//        ]);
//    }

    /**
     * @Route("annonce", name="annonce")
     * @IsGranted("ROLE_ADMIN")
     */
    public function cat_list(AnnonceRepository $repo)
    {

        $liste = $repo->findAll();
        return $this->render("annonce/table.html.twig"  , [ "liste" => $liste ]);
    }

    /**
     * @Route("annonce/add", name="annonce_add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add()
    {
        $form = $this->createForm(AnnonceType::class);

        return $this->render("annonce/index.html.twig"  , [ "form" => $form->createView()]);
    }
    
}
