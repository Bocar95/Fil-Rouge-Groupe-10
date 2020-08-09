<?php

namespace App\Controller;

use App\Entity\Referentiel;
use App\Entity\GroupeCompetences;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\GroupeCompetencesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReferentielController extends AbstractController
{
        /**
        * @Route(path="/api/admin/referentiels", name="api_add_referentiels", methods={"POST"})
        */
        public function addReferentiel(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManager,ValidatorInterface $validator,GroupeCompetencesRepository $GrpCompRepo)
        {
                $referentiel = new Referentiel();

                if($this->isGranted("EDIT",$referentiel)){
                        // Get Body content of the Request
                        $referentielJson = $request->getContent();

                        // On transforme le json en tableau
                        $referentielTab = $serializer->decode($referentielJson, 'json');
                        
                        $referentiel->setLibelle($referentielTab["libelle"]);
                        $referentiel->setPresentation($referentielTab["presentation"]);

                        $grpCompetencesTab = $referentielTab["groupeCompetences"];

                        foreach ($grpCompetencesTab as $key => $value){
                          $grpCompetences = new GroupeCompetences();
                          foreach ($value as $k => $v) {
                            $grpCompetences = $GrpCompRepo -> find($v);
                            if (isset($grpCompetences)){
                              
                            }
                          }
                        }
                        dd($grpCompe);
                        


                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($referentiel);
                        $entityManager->flush();
                        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
                }
                else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }

        }

}
