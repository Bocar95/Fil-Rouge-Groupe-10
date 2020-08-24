<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 * @UniqueEntity("titre",message="Ce titre est déja utilisé.")
 * @ApiResource(
 *      normalizationContext={"groups"={"Brief:read_B","Brief:read_all"}},
 *      collectionOperations={
 *          "get"={"path"="/formateurs/briefs"},
 *          "getPromoIdGroupeIdBriefs"={"methods"="get",
 *                  "path"="/formateurs/promo/{id}/groupe/{id}/briefs",
 *                  "defaults"={"id"=null},
 *                  "route_name"="apigetPromoIdGroupeIdBriefs"
 *          },
 *          "getPromosIdBriefs"={"methods"="get",
 *                  "path"="/formateurs/promos/{id}/briefs",
 *                  "defaults"={"id"=null},
 *                  "route_name"="apigetPromosIdBriefs"
 *          },
 *          "getFormateursIdBriefsBroullons"={"methods"="get",
 *                  "path"="/formateurs/{id}/briefs/broullons",
 *                  "defaults"={"id"=null},
 *                  "route_name"="apigetFormateursIdBriefsBroullons"
 *          },
 *          "getFormateursIdBriefsValide"={"methods"="get",
 *                  "path"="/formateurs/{id}/briefs/valide",
 *                  "defaults"={"id"=null},
 *                  "route_name"="apigetFormateursIdBriefsValide"
 *          },
 *          "getPromosIdBriefsId"={"methods"="get",
 *                  "path"="/formateurs/promos/{id1}/briefs/{id2}",
 *                  "defaults"={"id"=null},
 *                  "route_name"="apigetPromosIdBriefsId"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *                  "security_post_denormalize"="is_granted('VIEW', object)",
 *                  "security_post_denormalize_message"="Vous n'avez pas ce privilége.",
 *                  "path"="/formateurs/briefs/{id}",
 *                  "defaults"={"id"=null}
 *                }
 *      }
 * )
 */
class Brief
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $contexte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $modalitePedagogiques;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $critereDePerformance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $modaliteEvaluation;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     * @Groups({"Formateur:read_F"})
     */
    private $statutBrief;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="briefs")
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $referentiel;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="brief")
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $niveaux;

    /**
     * @ORM\ManyToMany(targetEntity=LivrablesAttendus::class, inversedBy="briefs")
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"Formateur:read_F"})
     */
    private $livrablesAttendus;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="briefs")
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $tag;

    /**
     * @ORM\OneToMany(targetEntity=Ressource::class, mappedBy="brief")
     * @Groups({"Brief:read_B"})
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"PromoBrief:read_PB"})
     * @Groups({"Formateur:read_F"})
     */
    private $ressource;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="briefs")
     * @Groups({"GroupeApprenant:read_GA"})
     * @Groups({"Brief:read_B"})
     * @Groups({"PromoBrief:read_PB"})
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeApprenant::class, inversedBy="briefs")
     * @Groups({"PromoBrief:read_PB"})
     */
    private $groupeApprenant;

    /**
     * @ORM\OneToMany(targetEntity=PromoBrief::class, mappedBy="brief")
     */
    private $promoBrief;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->livrablesAttendus = new ArrayCollection();
        $this->tag = new ArrayCollection();
        $this->ressource = new ArrayCollection();
        $this->groupeApprenant = new ArrayCollection();
        $this->promoBrief = new ArrayCollection();
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
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getContexte(): ?string
    {
        return $this->contexte;
    }

    public function setContexte(?string $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getModalitePedagogiques(): ?string
    {
        return $this->modalitePedagogiques;
    }

    public function setModalitePedagogiques(?string $modalitePedagogiques): self
    {
        $this->modalitePedagogiques = $modalitePedagogiques;

        return $this;
    }

    public function getCritereDePerformance(): ?string
    {
        return $this->critereDePerformance;
    }

    public function setCritereDePerformance(?string $critereDePerformance): self
    {
        $this->critereDePerformance = $critereDePerformance;

        return $this;
    }

    public function getModaliteEvaluation(): ?string
    {
        return $this->modaliteEvaluation;
    }

    public function setModaliteEvaluation(?string $modaliteEvaluation): self
    {
        $this->modaliteEvaluation = $modaliteEvaluation;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getStatutBrief(): ?string
    {
        return $this->statutBrief;
    }

    public function setStatutBrief(?string $statutBrief): self
    {
        $this->statutBrief = $statutBrief;

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
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setBrief($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->contains($niveau)) {
            $this->niveaux->removeElement($niveau);
            // set the owning side to null (unless already changed)
            if ($niveau->getBrief() === $this) {
                $niveau->setBrief(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LivrablesAttendus[]
     */
    public function getLivrablesAttendus(): Collection
    {
        return $this->livrablesAttendus;
    }

    public function addLivrablesAttendu(LivrablesAttendus $livrablesAttendu): self
    {
        if (!$this->livrablesAttendus->contains($livrablesAttendu)) {
            $this->livrablesAttendus[] = $livrablesAttendu;
        }

        return $this;
    }

    public function removeLivrablesAttendu(LivrablesAttendus $livrablesAttendu): self
    {
        if ($this->livrablesAttendus->contains($livrablesAttendu)) {
            $this->livrablesAttendus->removeElement($livrablesAttendu);
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tag->contains($tag)) {
            $this->tag->removeElement($tag);
        }

        return $this;
    }

    /**
     * @return Collection|Ressource[]
     */
    public function getRessource(): Collection
    {
        return $this->ressource;
    }

    public function addRessource(Ressource $ressource): self
    {
        if (!$this->ressource->contains($ressource)) {
            $this->ressource[] = $ressource;
            $ressource->setBrief($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): self
    {
        if ($this->ressource->contains($ressource)) {
            $this->ressource->removeElement($ressource);
            // set the owning side to null (unless already changed)
            if ($ressource->getBrief() === $this) {
                $ressource->setBrief(null);
            }
        }

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    /**
     * @return Collection|GroupeApprenant[]
     */
    public function getGroupeApprenant(): Collection
    {
        return $this->groupeApprenant;
    }

    public function addGroupeApprenant(GroupeApprenant $groupeApprenant): self
    {
        if (!$this->groupeApprenant->contains($groupeApprenant)) {
            $this->groupeApprenant[] = $groupeApprenant;
        }

        return $this;
    }

    public function removeGroupeApprenant(GroupeApprenant $groupeApprenant): self
    {
        if ($this->groupeApprenant->contains($groupeApprenant)) {
            $this->groupeApprenant->removeElement($groupeApprenant);
        }

        return $this;
    }

    /**
     * @return Collection|PromoBrief[]
     */
    public function getPromoBrief(): Collection
    {
        return $this->promoBrief;
    }

    public function addPromoBrief(PromoBrief $promoBrief): self
    {
        if (!$this->promoBrief->contains($promoBrief)) {
            $this->promoBrief[] = $promoBrief;
            $promoBrief->setBrief($this);
        }

        return $this;
    }

    public function removePromoBrief(PromoBrief $promoBrief): self
    {
        if ($this->promoBrief->contains($promoBrief)) {
            $this->promoBrief->removeElement($promoBrief);
            // set the owning side to null (unless already changed)
            if ($promoBrief->getBrief() === $this) {
                $promoBrief->setBrief(null);
            }
        }

        return $this;
    }
}
