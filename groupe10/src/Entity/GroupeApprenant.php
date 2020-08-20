<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeApprenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeApprenantRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"GroupeApprenant:read_GA","GroupeApprenant:read_all"}},
 *      collectionOperations={
 *          "get"={"path"="/admin/groupes"},
 *          "getGroupesApprenants"={
 *                              "methods"="get",
 *                              "path"="/admin/groupes/apprenants",
 *                              "route_name"="apigetGroupesApprenants"
 *                            },
 *          "post"={
 *                  "security_post_denormalize"="is_granted('EDIT', object)",
 *                  "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                  "path"="/admin/groupes"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *                  "security_post_denormalize"="is_granted('VIEW', object)",
 *                  "path"="/admin/groupes/{id}",
 *                  "defaults"={"id"=null}
 *          },
 *          "PutGroupesId"={"methods"="put",
 *                  "security_post_denormalize"="is_granted('EDIT', object)",
 *                  "path"="/admin/groupes/{id}",
 *                  "defaults"={"id"=null},
 *                  "route_name"="apiPutGroupesId"
 *          },
 *          "deleteGroupesIdApprenant"={"methods"="delete",
 *                  "security_post_denormalize"="is_granted('EDIT', object)",
 *                  "path"="/admin/groupes/{id}/apprenant",
 *                  "defaults"={"id"=null},
 *                  "route_name"="apideleteGroupesIdApprenant"
 *          }
 *      }
 * )
 */
class GroupeApprenant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"Promo:read_P"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"Promo:read_P"})
     * @Groups({"Brief:read_B"})
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"Promo:read_P"})
     * @Groups({"Brief:read_B"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"Promo:read_P"})
     * @Groups({"Brief:read_B"})
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"Promo:read_P"})
     * @Groups({"Brief:read_B"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupeApprenants")
     * @Groups({"GroupeApprenant:read_GA"})
     */
    private $promo;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupeApprenants", cascade="persist")
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"Promo:read_P"})
     * @Groups({"Brief:read_B"})
     */
    private $apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupeApprenants")
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"Promo:read_P"})
     * @Groups({"Brief:read_B"})
     */
    private $formateurs;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, mappedBy="groupeApprenant")
     * @Groups({"GroupeApprenant:read_GA"})
     */
    private $briefs;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
        $this->briefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
        }

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->contains($formateur)) {
            $this->formateurs->removeElement($formateur);
        }

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
            $brief->addGroupeApprenant($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            $brief->removeGroupeApprenant($this);
        }

        return $this;
    }
}
