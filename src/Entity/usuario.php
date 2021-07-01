<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hpcdiat.usuario
 *
 * @ORM\Table(name="hpcdiat.USUARIO")
 * @ORM\Entity
 */
class usuario
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user_hpc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUserHpc;

    /**
     * @var string
     *
     * @ORM\Column(name="id_user_keycloak", type="string", length=50, nullable=false)
     */
    private $idUserKeycloak;

    /**
     * @var string
     *
     * @ORM\Column(name="id_user_AD", type="string", length=50, nullable=false)
     */
    private $idUserAd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellido", type="string", length=100, nullable=true)
     */
    private $apellido;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_activo", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $userActivo;

    /**
     * @ORM\OneToMany(targetEntity="usuarioDispositivo", mappedBy="usuario", orphanRemoval=true, cascade={"persist"}, fetch="EAGER" )
     * @ORM\JoinColumn(name="id_user_hpc", referencedColumnName="id_user_hpc")
    */
    private $usuarioDispositivo;

    public function __construct() {
        $this->usuarioDispositivo = new ArrayCollection();
    }

    public function getIdUserHpc(): ?int
    {
        return $this->idUserHpc;
    }

    public function getIdUserKeycloak(): ?string
    {
        return $this->idUserKeycloak;
    }

    public function setIdUserKeycloak(string $idUserKeycloak): self
    {
        $this->idUserKeycloak = $idUserKeycloak;

        return $this;
    }

    public function getIdUserAd(): ?string
    {
        return $this->idUserAd;
    }

    public function setIdUserAd(string $idUserAd): self
    {
        $this->idUserAd = $idUserAd;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
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

    public function getUserActivo(): ?string
    {
        return $this->userActivo;
    }

    public function setUserActivo(?string $userActivo): self
    {
        $this->userActivo = $userActivo;

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
            $usuarioDispositivo->setUsuario($this);
        }

        return $this;
    }

    public function removeUsuarioDispositivo(usuarioDispositivo $usuarioDispositivo): self
    {
        if ($this->usuarioDispositivo->removeElement($usuarioDispositivo)) {
            // set the owning side to null (unless already changed)
            if ($usuarioDispositivo->getUsuario() === $this) {
                $usuarioDispositivo->setUsuario(null);
            }
        }

        return $this;
    }
    
}
