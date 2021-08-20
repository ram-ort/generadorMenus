<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plato
 *
 * @ORM\Table(name="plato", indexes={@ORM\Index(name="tipo", columns={"tipo"})})
 * @ORM\Entity
 */
class Plato
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $nombre = 'NULL';

    /**
     * @var float|null
     *
     * @ORM\Column(name="calorias", type="float", precision=6, scale=2, nullable=true, options={"default"="NULL"})
     */
    private $calorias;

    /**
     * @var \Tipoplato
     *
     * @ORM\ManyToOne(targetEntity="Tipoplato")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo", referencedColumnName="id")
     * })
     */
    private $tipo;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCalorias(): ?float
    {
        return $this->calorias;
    }

    public function setCalorias(?float $calorias): self
    {
        $this->calorias = $calorias;

        return $this;
    }

    public function getTipo(): ?Tipoplato
    {
        return $this->tipo;
    }

    public function setTipo(?Tipoplato $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }


}
