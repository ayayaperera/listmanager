<?php

namespace App\Entity;

use App\Repository\CheckboxRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CheckboxRepository::class)]
class Checkbox
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $nombre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $info;

    #[ORM\Column(type: 'boolean')]
    private $estado;

    #[ORM\ManyToOne(targetEntity: Lista::class, inversedBy: 'Checkboxes')]
    #[ORM\JoinColumn(nullable: false)]
    private $lista;

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

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(?string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getLista(): ?Lista
    {
        return $this->lista;
    }

    public function setLista(?Lista $lista): self
    {
        $this->lista = $lista;

        return $this;
    }

    public function __toString()
    {
        return $this->nombre ?? '';
    }
}
