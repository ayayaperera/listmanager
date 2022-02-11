<?php

namespace App\Entity;

use App\Repository\ListaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListaRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Lista
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nombre;

    #[ORM\Column(type: 'date_immutable')]
    private $fecha;

    #[ORM\OneToMany(mappedBy: 'lista', targetEntity: Checkbox::class, orphanRemoval: true)]
    private $Checkboxes;

    #[ORM\ManyToOne(targetEntity: Etiqueta::class, inversedBy: 'listas')]
    private $etiqueta;

    public function __construct()
    {
        $this->Checkboxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFecha(): ?\DateTimeImmutable
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeImmutable $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * @return Collection|Checkbox[]
     */
    public function getCheckboxes(): Collection
    {
        return $this->Checkboxes;
    }

    public function addCheckbox(Checkbox $checkbox): self
    {
        if (!$this->Checkboxes->contains($checkbox)) {
            $this->Checkboxes[] = $checkbox;
            $checkbox->setLista($this);
        }

        return $this;
    }

    public function removeCheckbox(Checkbox $checkbox): self
    {
        if ($this->Checkboxes->removeElement($checkbox)) {
            // set the owning side to null (unless already changed)
            if ($checkbox->getLista() === $this) {
                $checkbox->setLista(null);
            }
        }

        return $this;
    }

    #[ORM\PrePersist]
    public function setFechaValue()
    {
        $this->fecha = new \DateTimeImmutable();
    }

    public function getEtiqueta(): ?Etiqueta
    {
        return $this->etiqueta;
    }

    public function setEtiqueta(?Etiqueta $etiqueta): self
    {
        $this->etiqueta = $etiqueta;

        return $this;
    }

    public function __toString()
    {
        return $this->nombre ?? '';
    }
}
