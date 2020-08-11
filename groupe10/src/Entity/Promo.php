<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"Promo:read_P","Promo:read_all"}},
 *      collectionOperations={
 *          "get"={"path"="/admin/promo"},
 *          "post"={
 *                  "security_post_denormalize"="is_granted('EDIT', object)",
 *                  "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                  "path"="/admin/promo"
 *          }
 *      }
 * )
 */
class Promo
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
     * @Groups({"Promo:read_P"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Promo:read_P"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Promo:read_P"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Promo:read_P"})
     */
    private $lieu;

    /**
     * @ORM\Column(type="date")
     * @Groups({"Promo:read_P"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * @Groups({"Promo:read_P"})
     */
    private $dateFinProvisoire;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"Promo:read_P"})
     */
    private $dateFinReelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Promo:read_P"})
     */
    private $fabrique;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"Promo:read_P"})
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="promos")
     * @Groups({"Promo:read_P"})
     */
    private $referentiel;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="promos")
     * @Groups({"Promo:read_P"})
     */
    private $formateurs;

    /**
     * @ORM\OneToMany(targetEntity=GroupeApprenant::class, mappedBy="promo", cascade="persist")
     * @Groups({"Promo:read_P"})
     */
    private $groupeApprenants;

    /**
     * @ORM\ManyToOne(targetEntity=Admin::class, inversedBy="promo")
     */
    private $admin;

    public function __construct()
    {
        $this->groupeApprenants = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFinProvisoire(): ?\DateTimeInterface
    {
        return $this->dateFinProvisoire;
    }

    public function setDateFinProvisoire(\DateTimeInterface $dateFinProvisoire): self
    {
        $this->dateFinProvisoire = $dateFinProvisoire;

        return $this;
    }

    public function getDateFinReelle(): ?\DateTimeInterface
    {
        return $this->dateFinReelle;
    }

    public function setDateFinReelle(?\DateTimeInterface $dateFinReelle): self
    {
        $this->dateFinReelle = $dateFinReelle;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->fabrique;
    }

    public function setFabrique(string $fabrique): self
    {
        $this->fabrique = $fabrique;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

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
     * @return Collection|GroupeApprenant[]
     */
    public function getGroupeApprenants(): Collection
    {
        return $this->groupeApprenants;
    }

    public function addGroupeApprenant(GroupeApprenant $groupeApprenant): self
    {
        if (!$this->groupeApprenants->contains($groupeApprenant)) {
            $this->groupeApprenants[] = $groupeApprenant;
            $groupeApprenant->setPromo($this);
        }

        return $this;
    }

    public function removeGroupeApprenant(GroupeApprenant $groupeApprenant): self
    {
        if ($this->groupeApprenants->contains($groupeApprenant)) {
            $this->groupeApprenants->removeElement($groupeApprenant);
            // set the owning side to null (unless already changed)
            if ($groupeApprenant->getPromo() === $this) {
                $groupeApprenant->setPromo(null);
            }
        }

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }
}
