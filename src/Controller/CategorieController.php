<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class CategorieController extends AbstractController
{
    /**
     * @Route("admin/categorie", name="categorie")
     */
    public function cat_list(CategorieRepository $repo)
    {

        $liste = $repo->findAll();
        return $this->render("categorie/table.html.twig"  , [ "liste" => $liste ]);
    }

    /**
     * @Route("admin/categorie/add", name="categorie_form", methods="GET")
     */
    public function form(Request $request)
    {
        $form = $this->createForm(CategorieType::class);
        return $this->render("categorie/index.html.twig"  , [ "form" => $form->createView() ]);
    }

    /**
     * @Route("admin/categorie/add", name="categorie_add", methods="POST" )
     */
    public function add(Request $request, EntityManagerInterface $em)
    {

        // Créé le formulaire
        $form = $this->createForm(CategorieType::class);

        // Passer le requete HTTP au formulaire
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            // Récuperer les données envoyées
            $data = $form->getData();
            $em->persist($data);
            $em->flush();
            $this->addFlash('success', 'La categorie a bien été enregistré');

        }
        elseif(!$form->isValid()){
//            $this->addFlash('error','Les données du formulaires ne sont pas valides');
//            $form = $this->createForm(CategorieType::class, $form->getData());
            return $this->render('categorie/index.html.twig',['form' => $form->createView()]);
        }

        /// Les données du $_POST peuvent etre recuperes avec
        /// $request->request->get("nomDuFormulaire")qui est un array (comme $_POST)

//        $cat = new Categorie;
//        $titre = $request->request->get("categorie")["titre"];
//        $motscles = $request->request->get("categorie")["motscles"];
//        $cat->setTitre($titre);
//        $cat->setMotscles($motscles);
//        $em->persist($cat);
//        $em->flush();
//        $this->addFlash('success', 'La categorie a bien été enregistré');

        return $this->redirectToRoute("categorie");
    }


//    /**
//     * @Route("admin/categorie/delete/{id}", name="categorie_delete")
//     */
//    public function cat_delete(CategorieRepository $repo, EntityManagerInterface $em, int $id)
//    {
//        $cat = $repo->find($id);
//        if($_POST){
//            $em->remove($cat);
//            $em->flush();
//            return $this->redirectToRoute("categorie");
//
//        }
//        $this->addFlash('success', 'La categorie a bien été supprimé');
//        return $this->redirectToRoute("categorie");
//
//    }

}

