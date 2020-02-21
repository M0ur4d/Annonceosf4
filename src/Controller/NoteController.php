<?php

namespace App\Controller;

use App\Form\NoteType;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    /**
     * @Route("admin/note", name="note")
     */
    public function note_list(NoteRepository $repo)
    {

        $liste = $repo->findAll();
        return $this->render("note/table.html.twig"  , [ "liste" => $liste]);

    }

    /**
     * @Route("admin/note/add", name="note_add")
     */
    public function add()
    {
        $form = $this->createForm(NoteType::class);

        return $this->render("note/index.html.twig"  , [ "form" => $form->createView()]);
    }
}
