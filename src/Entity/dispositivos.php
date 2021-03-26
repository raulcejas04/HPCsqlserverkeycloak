<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hpcdiat.dispositivos
 *
 * @ORM\Table(name="hpcdiat.DISPOSITIVOS")
 * @ORM\Entity
 */
class dispositivos
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_dispositivo_hpc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDispositivosHpc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=150, nullable=true)
     */
    private $descripcion;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_dispositivo_pics", type="integer", nullable=true)
     */
    private $idDispositivoPics;

    /**
     * @var int|null
     *
     * @ORM\Column(name="codigo_dispositivo", type="smallint", nullable=true)
     */
    private $codigoDispositivo;

    /**
     * @ORM\OneToMany(targetEntity="usuarioDispositivo", mappedBy="dispositivos", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_dispositivo_hpc", referencedColumnName="id_dispositivo_hpc")
    */
    private $usuarioDispositivo;

    public function __construct() {
        $this->usuarioDispositivo = new ArrayCollection();
    }

    public function getIdDispositivosHpc(): ?int
    {
        return $this->idDispositivosHpc;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getIdDispositivoPics(): ?int
    {
        return $this->idDispositivoPics;
    }

    public function setIdDispositivoPics(?int $idDispositivoPics): self
    {
        $this->idDispositivoPics = $idDispositivoPics;

        return $this;
    }

    public function getCodigoDispositivo(): ?int
    {
        return $this->codigoDispositivo;
    }

    public function setCodigoDispositivo(?int $codigoDispositivo): self
    {
        $this->codigoDispositivo = $codigoDispositivo;

        return $this;
    }

    /**
     * @return Collection|usuarioDispositivo[]
     */
    public function getUsuarioDispositivo(): Collection
    {
        return $this->usuarioDispositivo;
    }

    public function addUsuarioDispositivo(usuarioDispositivo $usuarioDispositivo): self
    {
        if (!$this->usuarioDispositivo->contains($usuarioDispositivo)) {
            $this->usuarioDispositivo[] = $usuarioDispositivo;
            $usuarioDispositivo->setDispositivos($this);
        }

        return $this;
    }

    public function removeUsuarioDispositivo(usuarioDispositivo $usuarioDispositivo): self
    {
        if ($this->usuarioDispositivo->removeElement($usuarioDispositivo)) {
            // set the owning side to null (unless already changed)
            if ($usuarioDispositivo->getDispositivos() === $this) {
                $usuarioDispositivo->setDispositivos(null);
            }
        }

        return $this;
    }

}
