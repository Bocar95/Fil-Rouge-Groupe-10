<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PromoBriefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PromoBriefRepository::class)
 */
class PromoBrief
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="promoBrief")
     */
    private $brief;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="promoBrief")
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity=LivrablesPartiels::class, mappedBy="promoBrief")
     */
    private $livrablesPartiels;

    /**
     * @ORM\ManyToOne(targetEntity=PromoBriefApprenant::class, inversedBy="promoBriefs")
     */
    private $promoBriefApprenant;

    public function __construct()
    {
        $this->livrablesPartiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

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
     * @return Collection|LivrablesPartiels[]
     */
    public function getLivrablesPartiels(): Collection
    {
        return $this->livrablesPartiels;
    }

    public function addLivrablesPartiel(LivrablesPartiels $livrablesPartiel): self
    {
        if (!$this->livrablesPartiels->contains($livrablesPartiel)) {
            $this->livrablesPartiels[] = $livrablesPartiel;
            $livrablesPartiel->setPromoBrief($this);
        }

        return $this;
    }

    public function removeLivrablesPartiel(LivrablesPartiels $livrablesPartiel): self
    {
        if ($this->livrablesPartiels->contains($livrablesPartiel)) {
            $this->livrablesPartiels->removeElement($livrablesPartiel);
            // set the owning side to null (unless already changed)
            if ($livrablesPartiel->getPromoBrief() === $this) {
                $livrablesPartiel->setPromoBrief(null);
            }
        }

        return $this;
    }

    public function getPromoBriefApprenant(): ?PromoBriefApprenant
    {
        return $this->promoBriefApprenant;
    }

    public function setPromoBriefApprenant(?PromoBriefApprenant $promoBriefApprenant): self
    {
        $this->promoBriefApprenant = $promoBriefApprenant;

        return $this;
    }

}
