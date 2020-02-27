<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Form\AnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Photo;

class MembreController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
     */
    public function index(AnnonceRepository $repo)
    {
        $mesannonces = $this->getUser()->getAnnonces();
        return $this->render("membre/vue.html.twig" , [ "mesannonces" => $mesannonces]);
    }

    /**
     * @Route("admin/membre_list", name="membre_list")
     */
    public function membre_list(UserRepository $repo)
    {

        $liste = $repo->findAll();
        return $this->render("membre/table.html.twig"  , [ "liste" => $liste]);
    }

    /**
     * @Route("admin/newmembre", name="newmembre")
     */
    public function newUser(EntityManagerInterface $em){

        if($_POST){
            if (!empty($_POST["nom"] &&
                !empty($_POST["prenom"]) &&
                !empty($_POST["pseudo"]) &&
                !empty($_POST["telephone"]) &&
                !empty($_POST["email"]) &&
                !empty($_POST["password"])
            )){

                $user = new User;
                $user->setNom($_POST["nom"]);
                $user->setPrenom($_POST["prenom"]);
                $user->setPseudo($_POST["pseudo"]);
                $user->setPassword($_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT));

                $user->setTelephone($_POST["telephone"]);
                $user->setEmail($_POST["email"]);

                $user->setCivilite($_POST["civilite"]= isset($_POST["civilite"]) ? $_POST["civilite"] : 0);
                $user->setRoles($_POST["roles"] = isset($_POST["roles"]) ? $_POST["roles"] : 0);

                $user->setDateEnregistrement((new \DateTime('now')));

                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute("membre_list");
            }
        }
        $msg = "Veuillez entrez un membre";
        return $this->render("membre/form.html.twig", ["message" => $msg]);
    }


    /**
     * @Route("admin/membre/delete/{id}", name="membre_delete")
     */
    public function membre_delete(UserRepository $repo, EntityManagerInterface $em, int $id)
    {
        $user = $repo->find($id);
        $msg = "Suppression du membre " .$user->getNom();
        if($_POST){
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute("membre_list");
        }
        return $this->render("membre/form.html.twig", ["user" => $user, "message" => $msg,
            "mode" => "suppression"]);

    }

    /**
     * @Route("/profil/annonce/ajouter", name="nouvelle_annonce")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function nouvelle_annonce(Request $rq, EntityManagerInterface $em){
        $form = $this->createForm(AnnonceType::class);
        $form->handleRequest($rq);

        if ($form->isSubmitted()){
            if($form->isValid()){
                $nvlAnnonce = $form->getData();
                $album = new Photo;
                $destination = $this->getParameter("dossier_images_annonces");
                for($i=1; $i<=5; $i++){
                    $champs = "photo" .$i;
                    if ($photoUploadee= $form[$champs]->getData()){
                        $nomPhoto = pathinfo($photoUploadee->getClientOriginalName(), PATHINFO_FILENAME);
                        $nouveauNom = trim($nomPhoto);
                        $nouveauNom = str_replace(" ", "_", $nouveauNom);
                        $nouveauNom .= "_" . uniqid() . "." . $photoUploadee->guessExtension();
                        $photoUploadee->move($destination, $nouveauNom);
                        $setter = "setPhoto$i";
                        $album->$setter($nouveauNom);
                    }
                }
                $em->persist($album);
                $em->flush();
                $nvlAnnonce->setDateEnregistrement( new \DateTime());
                $nvlAnnonce->setPhotoId($album);
                $nvlAnnonce->setMembreId($this->getUser());
                $em->persist($nvlAnnonce);
                $em->flush();
                $this->addFlash('success', 'L\'annonce a bien été enregistré');
                return $this->redirectToRoute("membre");
            }
            else{
                $this->addFlash('error', 'L\'annonce n\'a pas été enregistré');
            }
        }

        $form = $form->createView();
        return $this->render("membre/annonce.html.twig", compact("form"));

    }

    /**
     * @Route("/profil/annonce/modifie/{id}", name="modif_annonce")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function modif_annonce(Request $rq, EntityManagerInterface $em, int $id, AnnonceRepository $repo ){

            $modAnn = $repo->find($id);
            if($modAnn->getMembreId()->getId() == $this->getUser()->getId()) {

                $form = $this->createForm(AnnonceType::class, $modAnn);
                $form->handleRequest($rq);

                if ($form->isSubmitted()) {
                    if ($form->isValid()) {
                        $destination = $this->getParameter("dossier_images_annonces");
                        for ($i = 1; $i <= 5; $i++) {
                            $champs = "photo" . $i;
                            if ($photoUploadee = $form[$champs]->getData()) {
                                $nomPhoto = pathinfo($photoUploadee->getClientOriginalName(), PATHINFO_FILENAME);
                                $nouveauNom = trim($nomPhoto);
                                $nouveauNom = str_replace(" ", "_", $nouveauNom);
                                $nouveauNom .= "_" . uniqid() . "." . $photoUploadee->guessExtension();
                                $photoUploadee->move($destination, $nouveauNom);
                                $setter = "setPhoto$i";
                                $modAnn->getPhotoId()->$setter($nouveauNom);
                            }
                        }
                        $em->persist($modAnn);
                        $em->flush();
                        $this->addFlash('success', 'L\'annonce a bien été modifié');
                        return $this->redirectToRoute("membre");
                    } else {
                        $this->addFlash('error', 'L\'annonce n\'a pas été modifié');
                    }
                }

                $form = $form->createView();
                return $this->render("membre/annonce.html.twig", compact("form"));
            }else{
                $this->addFlash('error', 'Vous ne pouvez pas accédez a cet URL');
                return $this->redirectToRoute("membre");
            }
    }

    /**
     * @Route("/profil/annonce/delete/{id}", name="delete_annonce", methods={"GET", "POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function delete_annonce(Request $rq, EntityManagerInterface $em, int $id, AnnonceRepository $repo ){

        $ann = $repo->find($id);
        if (!$ann) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $em->remove($ann);
        $em->flush();
        $this->addFlash('success', 'L\'annonce a bien été supprimé');
        return $this->redirectToRoute('membre', ['id' => $ann->getId()]);

    }



}
