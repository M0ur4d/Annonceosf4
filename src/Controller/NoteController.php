<?php

namespace App\Controller;

use App\Form\NoteType;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


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
    public function add(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(NoteType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data->setMembreId($this->getUser());
            $data->setDateEnregistrement(new \DateTime('now'));
            $em->persist($data);
            $em->flush();
            $this->addFlash('success', 'La note a bien été enregistrée');

        } elseif (!$form->isValid()) {
//            $this->addFlash('error','Les données du formulaires ne sont pas valides');
//            $form = $this->createForm(CommentaireType::class, $form->getData());
            return $this->render('note/index.html.twig', ['form' => $form->createView()]);
        }
        return $this->redirectToRoute("note");
    }

//    public function add()
//    {
//        $form = $this->createForm(NoteType::class);
//
//        return $this->render("note/index.html.twig"  , [ "form" => $form->createView()]);
//    }
}
