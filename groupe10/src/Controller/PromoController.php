<?php

namespace App\Controller;

use DateTime;
use App\Entity\Promo;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\Referentiel;
use App\Entity\GroupeApprenant;
use App\Repository\AdminRepository;
use App\Repository\PromoRepository;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReferentielRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PromoController extends AbstractController
{

        /**
        * @Route(path="/api/admin/promo", name="api_get_promo", methods={"GET"})
        */
        public function getPromo(PromoRepository $repo)
        {
                $promo = new Promo;

                if($this->isGranted("VIEW",$promo)){
                        $promo = $repo->findAll();

                        return $this->json($promo,Response::HTTP_OK,);
                }else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }

        /**
        * @Route(path="/api/admin/promo", name="api_add_promo", methods={"POST"})
        */
        public function addPromo(Request $request,SerializerInterface $serializer, \Swift_Mailer $mailer, EntityManagerInterface $entityManager,ValidatorInterface $validator,ReferentielRepository $refRepo, FormateurRepository $formateurRepo, ApprenantRepository $apprenantRepo, AdminRepository $AdminRepo)
        {
                $promo = new Promo();

                if($this->isGranted("EDIT",$promo)){
                        // Get Body content of the Request
                        $promoJson = $request->getContent();

                        // On transforme le json en tableau
                        $promoTab = $serializer->decode($promoJson, 'json');

                        $promo->setLangue($promoTab["langue"]);
                        $promo->setTitre($promoTab["titre"]);
                        $promo->setDescription($promoTab["description"]);
                        $promo->setLieu($promoTab["lieu"]);
                        $promo->setDateDebut(new DateTime("08/02/2020"));
                        $promo->setDateFinProvisoire(new DateTime("08/12/2020"));
                        $promo->setFabrique($promoTab["fabrique"]);
                        $promo->setEtat($promoTab["etat"]);

                        $referentielTab = $promoTab["referentiel"];
                        $formateursTab = $promoTab["formateurs"];

                        foreach ($referentielTab as $key => $value){
                          $referentiel = new Referentiel();
                          $referentiel = $refRepo -> find($value);
                            if (isset($referentiel)){
                              $promo->setReferentiel($referentiel);
                            }
                        }

                        foreach ($formateursTab as $key => $value){
                          $formateur = new Formateur();
                          foreach ($value as $k => $v) {
                            $formateur = $formateurRepo -> find($v);
                            if (isset($formateur)){
                              $promo->addFormateur($formateur);
                            }
                          }
                        }

                        $groupeApprenantsTab = $promoTab["groupes"];

                        $date = new DateTime();
                        $date->format('Y-m-d H:i:s');

                        foreach ($groupeApprenantsTab as $key => $value) {
                          $groupeApprenants = new GroupeApprenant();

                          $groupeApprenants->setNom($value["nom"]);
                          $groupeApprenants->setType($value["type"]);
                          $groupeApprenants->setStatut($value["statut"]);
                          $groupeApprenants->setDateCreation($date);

                          $apprenantsTab = $value["apprenants"]; 
                          
                          foreach ($apprenantsTab as $k => $v) {
                            $apprenants = new Apprenant();

                            if ($apprenants = $apprenantRepo -> findOneByEmail($v["email"])){
                              $apprenantEmail = $apprenants->getEmail();

                              $groupeApprenants->addApprenant($apprenants);
                              $message = (new \Swift_Message('Selections Sonatel Académie'))
                                    ->setFrom('bocar.diallo95@gmail.com')
                                    ->setTo($apprenantEmail)
                                    ->setBody('Bonsoir Cher(e) candidat(e) de la Promotion 3 de sonatel Academy,
                                                Après les différentes étapes de sélection que tu as passé avec brio,
                                                nous t’informons que ta candidature a été retenue pour intégrer la troisième promotion de la première école de codage gratuite du Sénégal.
                                                Rendez-vous le 17 Février 2020 à 8 heures précises dans nos locaux du Orange Digital Center sis Immeuble Scalène Mermoz Ecole Police lot B Dakar. Merci de venir muni de ta pièce d’identité nationale ou passeport.')
                                                ;
                                    $mailer->send($message);
                            }
                            
                          }

                          $promo->addGroupeApprenant($groupeApprenants);

                        }

                        $token = substr($request->server->get("HTTP_AUTHORIZATION"), 7);
                        $token = explode(".",$token);

                        $payload = $token[1];
                        $payload = json_decode(base64_decode($payload));

                        $admin = $AdminRepo->findOneBy([
                                "username" => $payload->username
                        ]);

                        $promo->setAdmin($admin);

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($promo);
                        $entityManager->flush();
                        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
                }
                else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }
}
