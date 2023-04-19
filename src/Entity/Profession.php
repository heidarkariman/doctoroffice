<?php

namespace App\Entity;

use App\Repository\ProfessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessionRepository::class)]
class Profession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'profession_id', targetEntity: Coworker::class)]
    private Collection $coworkers;

    public function __construct()
    {
        $this->coworkers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Coworker>
     */
    public function getCoworkers(): Collection
    {
        return $this->coworkers;
    }

    public function addCoworker(Coworker $coworker): self
    {
        if (!$this->coworkers->contains($coworker)) {
            $this->coworkers->add($coworker);
            $coworker->setProfessionId($this);
        }

        return $this;
    }

    public function removeCoworker(Coworker $coworker): self
    {
        if ($this->coworkers->removeElement($coworker)) {
            // set the owning side to null (unless already changed)
            if ($coworker->getProfessionId() === $this) {
                $coworker->setProfessionId(null);
            }
        }

        return $this;
    }
}
