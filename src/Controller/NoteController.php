<?php

namespace App\Controller;

use App\Form\NoteType;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository as UR;


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
     * @Route("profil/attribuer-note/{pseudo}", name="attribuer_note")
     */
    public function attribuer(UR $mr, Request $rq, EntityManagerInterface $em, $pseudo){
        if($pseudo == $this->getUser()->getPseudo()){
            $this->addFlash("error", "Vous ne pouvez pas vous noter vous-même, petit salopiaud !");
            return $this->redirectToRoute("profil");
        }

        $membre = $mr->findOneBy([ "pseudo" => $pseudo ]);

        $form = $this->createForm(NoteType::class);
        $form->handleRequest($rq);
        if($form->isSubmitted()){
            if($form->isValid()){
                $note = $form->getData();
                $note->setMembreNotant($this->getUser());
                $note->setDateEnregistrement(new \DateTime());
                $note->setMembreNote($membre);
                $em->persist($note);
                $em->flush();
                $this->addFlash("success", "Votre note a bien été prise en compte");
                return $this->redirectToRoute("membre");
            }
            else{
                $this->addFlash("error", "Une erreur est survenu !");
            }
        }

        $form = $form->createView();
        return $this->render("note/attribuer.html.twig", compact("membre", "form"));
    }
}
