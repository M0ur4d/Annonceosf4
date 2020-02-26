<?php

namespace App\Controller;


use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class CommentaireController extends AbstractController
{
    /**
     * @Route("admin/commentaire", name="commentaire")
     */
    public function com_list(CommentaireRepository $repo)
    {

            $liste = $repo->findAll();
            return $this->render("commentaire/table.html.twig"  , [ "liste" => $liste]);

    }

    /**
     * @Route("admin/commentaire/add", name="commentaire_form", methods="GET")
     */
    public function form(Request $request)
    {
        $form = $this->createForm(CommentaireType::class);
        return $this->render("commentaire/index.html.twig"  , [ "form" => $form->createView() ]);
    }

    /**
     * @Route("admin/commentaire/add", name="commentaire_add", methods="POST")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {

        // Créé le formulaire
        $form = $this->createForm(CommentaireType::class);

        // Passer le requete HTTP au formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récuperer les données envoyées
            $data = $form->getData();
            $data->setMembreId($this->getUser());
            $data->setDateEnregistrement(new \DateTime('now'));
            $em->persist($data);
            $em->flush();
            $this->addFlash('success', 'Le commentaire a bien été enregistré');

        } elseif (!$form->isValid()) {
//            $this->addFlash('error','Les données du formulaires ne sont pas valides');
//            $form = $this->createForm(CommentaireType::class, $form->getData());
            return $this->render('commentaire/index.html.twig', ['form' => $form->createView()]);
        }
        return $this->redirectToRoute("commentaire");
    }
}
