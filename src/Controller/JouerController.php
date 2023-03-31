<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PersonnageRepository;
use App\Form\PersonnageType;
use App\Entity\Personnage;
use App\Repository\AventureRepository;
use App\Repository\PartieRepository;
use App\Entity\Partie;
use App\Repository\EtapeRepository;


class JouerController extends AbstractController
{
    #[Route('/jouer', name: 'app_jouer')]
    public function index(PersonnageRepository $personnageRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $personnages = $personnageRepository->findBy(["user"=>$this->getUser()]);
        return $this->render('jouer/index.html.twig', [
            'personnages' => $personnages ,
        ]);
    }

    #[Route('/jouer/new', name: 'app_jouer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PersonnageRepository $personnageRepository): Response 
    {

        $personnage = new Personnage();
        $form = $this->createForm(PersonnageType::class, $personnage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $personnage->setUser($this->getUser());
            $personnageRepository->save($personnage, true);
            

            return $this->redirectToRoute('app_jouer', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jouer/new_personnage.html.twig', [
            'personnage' => $personnage,
            'form' => $form
            
        ]);

    }

    #[Route('/jouer/aventures/{idPersonnage}', name: 'app_choix_aventure', methods: ['GET'])]
    public function afficherAventures( PersonnageRepository $personnageRepository,AventureRepository $AventureRepository,$idPersonnage, ): Response
    {
        $personnage = $personnageRepository->find($idPersonnage);
        $aventures = $AventureRepository->findAll();

        return $this->render('jouer/aventures.html.twig', [
            'personnage' => $personnage,
            'aventures' => $aventures
        ]);
    }

    #[Route('/jouer/aventure/{idPersonnage}/{idAventure}', name: 'app_start_aventure', methods: ['GET'])]
    public function demarrerAventure( PersonnageRepository $personnageRepository,AventureRepository $AventureRepository,PartieRepository $partieRepository,$idPersonnage,$idAventure): Response
    {
        

        $personnage = $personnageRepository->find($idPersonnage);
        $aventure = $AventureRepository->find($idAventure);
        $partie = $partieRepository->findOneBy(array('aventurier'=>$personnage,'aventure'=>$aventure));
        $isNewPartie = !isset($partie);

        if ($isNewPartie)
        {
            $isNewPartie = true;
            $partie=new Partie();
            $partie->setAventurier($personnage);
            $partie->setAventure($aventure);
            $partie->setEtape($aventure->getPremiereEtape());
            $partie->setDatePartie(new \DateTime('now'));
            $partieRepository->save($partie,true);
        }

        return $this->render('jouer/aventure-start.html.twig', [
            'personnage' => $personnage,
            'aventures' => $aventure,
            'partie' => $partie,
        ]);
    }

    #[Route('/jouer/etape/{idPartie}/{idEtape}/{idPersonnage}', name:'app_play_aventure', methods:['GET'])]
    public function jouerEtape ($idPartie, $idEtape,$idPersonnage, PartieRepository $partieRepository, EtapeRepository $etapeRepository, PersonnageRepository $personnageRepository): Response
    {
        $etape = $etapeRepository->find($idEtape);
        $partie = $partieRepository->find($idPartie);
        $personnage = $personnageRepository->find($idPersonnage);
        $partie->setEtape($etape);

        if ($etape->getFinAventure()!=null)
            {
            return $this->redirectToRoute('app_finir_aventure',['idPersonnage'=> $personnage->getId(), 'idAventure'=> $etape->getAventure()->getId(), 'idEtape'=> $etape->getId()]);
            }
            else
                return $this->render('jouer/aventure-play.html.twig', ['etape'=> $etape, 'partie'=>$partie, 'personnage'=> $personnage]);
        }
        

    #[Route('/jouer/aventure/finir/{idPersonnage}/{idAventure}/{idEtape}', name: 'app_finir_aventure', methods:['GET'])] 
    public function finirPartie ($idPersonnage,$idAventure, $idEtape, PersonnageRepository $personnageRepository, EtapeRepository $etapeRepository, AventureRepository $aventureRepository): Response
    {
        $personnage = $personnageRepository->find($idPersonnage);
        $etape = $etapeRepository->find($idEtape);
        return $this->render("jouer/aventure-end.html.twig", ['etape'=>$etape,'personnage'=>$personnage]);
    }

}










