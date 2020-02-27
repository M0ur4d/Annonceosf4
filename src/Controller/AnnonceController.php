<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface as EMI;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class AnnonceController extends AbstractController
{
    /**
     * @Route("annonce/fiche/{id}", name="fiche_annonce")
     */
    public function index(Request $rq, EMI $em, int $id, AnnonceRepository $repo, NoteRepository $nm )
    {
        $annonce = $repo->find($id);
        $touteann = $repo->findAll();

        $moyenne = $nm->avgUser($annonce->getMembreId()->getId());




        return $this->render("annonce/ficheannonce.html.twig", ["annonce" => $annonce,
                                                                      "touteann" => $touteann,
                                                                      "moyenne" => $moyenne]);
    }

    /**
     * @Route("annonce", name="annonce")
     * @IsGranted("ROLE_ADMIN")
     */
    public function cat_list(AnnonceRepository $repo)
    {

        $liste = $repo->findAll();
        return $this->render("annonce/table.html.twig"  , [ "liste" => $liste ]);
    }
//
//    /**
//     * @Route("annonce/add", name="annonce_add")
//     * @IsGranted("IS_AUTHENTICATED_FULLY")
//     */
//    public function add()
//    {
//        $form = $this->createForm(AnnonceType::class);
//
//        return $this->render("annonce/index.ht
//ml.twig"  , [ "form" => $form->createView()]);
//    }

//    /**
//     * @Route("annonce/add", name="annonce_form", methods="GET")
//     * @IsGranted("IS_AUTHENTICATED_FULLY")
//     */
//    public function form(Request $request)
//    {
//        $form = $this->createForm(AnnonceType::class);
//        return $this->render("annonce/index.html.twig"  , [ "form" => $form->createView() ]);
//    }

//    /**
//     * @Route("annonce/add", name="annonce_add", methods="POST")
//     * @IsGranted("IS_AUTHENTICATED_FULLY")
//     */
//    public function add(Request $request, EntityManagerInterface $em)
//    {
//
//        $form = $this->createForm(AnnonceType::class);
//
//        $form->handleRequest($request);
//        if($form->isSubmitted() && $form->isValid() ){
//
//            $photo = new Photo;
//            $photo->setPhoto1("378.jpg");
//
//            $data = $form->getData();
//            $data->setDateEnregistrement(new \DateTime('now'));
//            $data->setPhotoId($photo);
//
//            $data->setMembreId($this->getUser());
//            $em->persist($data);
//            $em->flush();
//            $this->addFlash('success', 'L\'annonce a bien été enregistré');
//
//        }
//        elseif(!$form->isValid()){
////            $this->addFlash('error','Les données du formulaires ne sont pas valides');
////            $form = $this->createForm(AnnonceType::class, $form->getData());
//            return $this->render('annonce/index.html.twig',['form' => $form->createView()]);
//        }
//        return $this->redirectToRoute("accueil");
//    }
    
}
