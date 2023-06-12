<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActorRepository::class)]
class Actor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Programm::class, inversedBy: 'actors')]
    private Collection $programm;

    public function __construct()
    {
        $this->programm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Programm>
     */
    public function getProgramm(): Collection
    {
        return $this->programm;
    }

    public function addProgramm(Programm $programm): self
    {
        if (!$this->programm->contains($programm)) {
            $this->programm->add($programm);
        }

        return $this;
    }

    public function removeProgramm(Programm $programm): self
    {
        $this->programm->removeElement($programm);

        return $this;
    }
}
