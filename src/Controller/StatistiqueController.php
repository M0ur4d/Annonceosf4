<?php

namespace App\Controller;


use App\Repository\AnnonceRepository;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class StatistiqueController extends AbstractController
{
    /**
     * @Route("/statistique", name="statistique")
     */
    public function index(NoteRepository $ur, AnnonceRepository $ar)
    {
        $top5membres = $ur->findTop5MembresNotes();
        $top5mbannonce = $ar->findTop5MembresActifs();
        return $this->render('statistique/index.html.twig', compact( "top5membres", "top5mbannonce" ) );
    }


}
