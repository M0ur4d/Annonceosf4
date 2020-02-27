<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnonceRepository as AR;
use App\Repository\CategorieRepository as CR;
use App\Repository\UserRepository as UR;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(AR $annRepo, CR $catRepo, UR $userRepo, Request $rq)
    {

        $categorie_choisie = null;
        $membre_choisi = null;
        $ville_choisie = null;
        $prix_choisi = 0;

        if($rq->getMethod() == "POST"){
            $where = [];
            if($categorie_choisie = $rq->request->get("categorie")){
                $where["categorie_id"] = $categorie_choisie;
            }
            if($membre_choisi = $rq->request->get("membre")){
                $where["membre_id"] = $membre_choisi;
            }
            if($ville_choisie = $rq->request->get("region")){
//                $where["ville"] = $rq->request->get("region");
                $where["ville"] = $ville_choisie;
            }
            $annonce = $annRepo->findBy($where);

            if($prix_choisi = $rq->request->get("prix")){
                // La fonction array_filter permet de filtre mes valeurs d'un array selon le resultat d'un fonction
                // (appelé callback)
                // cette fonction doit retourner un boolean ( si le reout vaut true, la valeur
                // de l'array est gardée dans le resultat final).
                // array_filter retourne un array
                // NB : la fonction callback n'a pas acces aux variables exterieurs a sa declaration.
                //      pour pouvoir utiliser une variable existante, il faut l'utiliser.
                $annonce = array_filter($annonce, function($ann) use($prix_choisi){
                   return $ann->getPrix() <= $prix_choisi;
                });
            }


        }else{
            $annonce = $annRepo->findAll();
        }

        $categorie = $catRepo->findAll();
        $user = $userRepo->findByRole("ROLE_USER");
        $region = $annRepo->distinctVille();
        $topannonce = $annRepo->topAnnonce();
//        dd($topannonce);

        return $this->render('base.html.twig', compact("categorie", "user", "annonce", "region", "prix_choisi", "ville_choisie", "membre_choisi", "categorie_choisie", "topannonce"));

    }

    /**
     * @Route("/admin/", name="accueil_admin")
     * @IsGranted("ROLE_ADMIN")

     */
    public function index_admin(AR $annRepo, CR $catRepo, UR $userRepo)
    {
        $categories = $catRepo->findAll();
        $users = $userRepo->findAll();

        $regions = $annRepo->distinctVille();

        $annonces = $annRepo->findAll();

        return $this->render('admin_base.html.twig', compact("categories", "users", "annonces", "regions"));

    }

}
