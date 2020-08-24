<?php

namespace App\Controller;

use App\Entity\Brief;
use App\Entity\Promo;
use App\Entity\Formateur;
use App\Entity\GroupeApprenant;
use App\Repository\BriefRepository;
use App\Repository\PromoRepository;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GroupeApprenantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BriefController extends AbstractController
{
        /**
        * @Route(path="/api/formateurs/briefs", name="api_get_briefs", methods={"GET"})
        */
        public function getBriefs(BriefRepository $repo)
        {
          $brief = new Brief();

          if($this->isGranted("VIEW",$brief)){
            $brief = $repo->findAll();

            return $this->json($brief,Response::HTTP_OK,);
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/formateurs/promo/{id}/groupe/{id2}/briefs",
        *        name="apigetPromoIdGroupeIdBriefs",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getPromoIdGroupeIdBriefs",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="getPromoIdGroupeIdBriefs"
        *         }
        *)
        */
        public function getPromoIdGroupeIdBriefs(Request $request,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $PromoRepo, GroupeApprenantRepository $GaRepo)
        {
          $promo = new Promo();
          $brief = new Brief();

          $uri = $request->getUri();
          $uriTab = explode("/", $uri);
          $id1 = $uriTab[6];
          $id2 = $uriTab[8];

          if($this->isGranted("VIEW",$brief)){

            //On détermine si la promo existe dans la base de données
            $promo = $PromoRepo-> find($id1);
                        
            if (isset($promo)){
                                        
              // On transforme l'objet promo en tableau.
              $promoTab = $serializer->normalize($promo, 'json');

              $groupeApprenantInPromo = $promoTab["groupeApprenants"];
              
              foreach ($groupeApprenantInPromo as $key1 => $value1) {
                $nomGroupeInPromo []= $value1["nom"];
              }

              $groupeApprenant = new GroupeApprenant();

              $groupeApprenant = $GaRepo-> find($id2);

              if (isset($groupeApprenant)){
                // On transforme l'objet  en tableau.
                $groupeApprenantTab = $serializer->normalize($groupeApprenant, 'json');

                $nomGroupe = $groupeApprenantTab["nom"];

                foreach ($nomGroupeInPromo as $key2 => $value2) {
                  if ($value2 == $nomGroupe){
                    $briefs = $groupeApprenantTab["briefs"];
                  }
                }

                //On récupére les briefs de la promo qu'on met dans un tableau

                return $this->json($briefs,Response::HTTP_OK,);
              }
              
            }else{
              return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }
              
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/formateurs/promos/{id}/briefs",
        *        name="apigetPromosIdBriefs",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getPromosIdBriefs",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="getPromosIdBriefs"
        *         }
        *)
        */
        public function getPromosIdBriefs(Request $request,$id,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $PromoRepo)
        {
          $promo = new Promo();
          $brief = new Brief();

          if($this->isGranted("VIEW",$brief)){
            $promo = $PromoRepo->find($id);

            if (isset($promo)){
              // On transforme l'objet promo en tableau.
              $promoTab = $serializer->normalize($promo, 'json');

              $promoBriefsTab = $promoTab["promoBriefs"];

              foreach ($promoBriefsTab as $key => $value) {
                $briefsTab []= $value["brief"];
              }

              return $this->json($briefsTab,Response::HTTP_OK,);

            }else{
              return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }

          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/formateurs/{id}/briefs/broullons",
        *        name="apigetFormateursIdBriefsBroullons",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getFormateursIdBriefsBroullons",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="getFormateursIdBriefsBroullons"
        *         }
        *)
        */
        public function getFormateursIdBriefsBroullons(Request $request,$id,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, FormateurRepository $formateurRepo)
        {
          $brief = new Brief();
          $formateur = new Formateur();

          if($this->isGranted("VIEW",$brief)){
            $formateur = $formateurRepo->find($id);

            if (isset($formateur)){
              $formateurTab = $serializer->normalize($formateur, 'json');

              $briefTab = $formateurTab["briefs"];

              foreach ($briefTab as $key => $value) {
                $statutBrief = $value["statutBrief"];
                  if($statutBrief == "broullon"){
                    $briefBroullon [] = $value;
                  }
              }

              return $this->json($briefBroullon,Response::HTTP_OK,);

            }else{
              return $this->json(["message" => "Ce formateur n'existe pas."], Response::HTTP_FORBIDDEN);
            }

          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/formateurs/{id}/briefs/valide",
        *        name="apigetFormateursIdBriefsValide",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getFormateursIdBriefsValide",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="getFormateursIdBriefsValide"
        *         }
        *)
        */
        public function getFormateursIdBriefsValide(Request $request,$id,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, FormateurRepository $formateurRepo)
        {
          $brief = new Brief();
          $formateur = new Formateur();

          if($this->isGranted("VIEW",$brief)){
            $formateur = $formateurRepo->find($id);

            if (isset($formateur)){
              $formateurTab = $serializer->normalize($formateur, 'json');

              $briefTab = $formateurTab["briefs"];

              foreach ($briefTab as $key => $value) {
                $statutBrief = $value["statutBrief"];
                  if($statutBrief == "valide"){
                    $briefValide [] = $value;
                  }
              }

              return $this->json($briefValide,Response::HTTP_OK,);

            }else{
              return $this->json(["message" => "Ce formateur n'existe pas."], Response::HTTP_FORBIDDEN);
            }

          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/formateurs/promos/{id1}/briefs/{id2}",
        *        name="apigetPromosIdBriefsId",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getPromosIdBriefsId",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="getPromosIdBriefsId"
        *         }
        *)
        */
        public function getPromosIdBriefsId(Request $request,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $PromoRepo, BriefRepository $briefRepo)
        {
          $promo = new Promo();
          $brief = new Brief();

          $uri = $request->getUri();
          $uriTab = explode("/", $uri);
          $id1 = $uriTab[6];
          $id2 = $uriTab[8];
          if($this->isGranted("VIEW",$brief)){
            $promo = $PromoRepo->find($id1);
            $brief = $briefRepo->find($id2);

            if (isset($promo)){
              // On transforme l'objet promo en tableau.
              $promoTab = $serializer->normalize($promo, 'json');

              $promoBriefsTab = $promoTab["promoBriefs"];

              foreach ($promoBriefsTab as $key => $value) {
                $briefsTab1 []= $value["brief"];
              }

              if(isset($brief)){
                // On transforme l'objet brief en tableau.
                $briefsTab2 = $serializer->normalize($brief, 'json');

                foreach ($briefsTab1 as $key2 => $value2) {
                  if ($briefsTab2["titre"] == $value2["titre"]){
                    return $this->json($brief,Response::HTTP_OK,);
                  }
                }

                return $this->json(["message" => "Ce brief n'est pas dans ce promo."], Response::HTTP_FORBIDDEN);
              }

            }else{
              return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }
          
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/apprenants/promos/{id}/briefs",
        *        name="apigetApprenantsPromosIdBriefs",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getApprenantsPromosIdBriefs",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="getApprenantsPromosIdBriefs"
        *         }
        *)
        */
        public function getApprenantsPromosIdBriefs(Request $request,$id,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $PromoRepo)
        {
          $promo = new Promo();
          $brief = new Brief();

          if($this->isGranted("VIEW",$brief)){
            $promo = $PromoRepo->find($id);

            if (isset($promo)){
              // On transforme l'objet promo en tableau.
              $promoTab = $serializer->normalize($promo, 'json');

              $groupeApprenantsTab = $promoTab["groupeApprenants"];

              foreach ($groupeApprenantsTab as $key => $value) {
                if(!empty($value["briefs"])){
                  $briefsTab []= $value["briefs"];
                }
              }

              return $this->json($briefsTab,Response::HTTP_OK,);

            }else{
              return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }

          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

}
