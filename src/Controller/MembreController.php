<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class MembreController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
     */
    public function index()
    {
        return $this->render("membre/vue.html.twig");
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

}
