<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * Hpcdiat.usuarioDispositivo
 *
 * @ORM\Table(name="hpcdiat.USUARIO_DISPOSITIVO")
 * @ORM\Entity
 */
class UsuarioDispositivo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Dispositivos", inversedBy="usuarioDispositivo")
     * @ORM\JoinColumn(name="id_dispositivo_hpc", referencedColumnName="id_dispositivo_hpc")
    */
    private $dispositivos;
    //private $idDispositivoHpc;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="usuarioDispositivo")
     * @ORM\JoinColumn(name="id_user_hpc", referencedColumnName="id_user_hpc")
    */
    private $usuario;
    //private $idUserHpc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="can_read", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $canRead;

    /**
     * @var string|null
     *
     * @ORM\Column(name="can_write", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $canWrite;

    public function __construct() {
        $this->dispositivos = new ArrayCollection();
        $this->usuario = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCanRead(): ?string
    {
        return $this->canRead;
    }

    public function setCanRead(?string $canRead): self
    {
        $this->canRead = $canRead;

        return $this;
    }

    public function getCanWrite(): ?string
    {
        return $this->canWrite;
    }

    public function setCanWrite(?string $canWrite): self
    {
        $this->canWrite = $canWrite;

        return $this;
    }

    public function getDispositivos(): ?Dispositivos
    {
        return $this->dispositivos;
    }

    public function setDispositivos(?Dispositivos $dispositivos): self
    {
        $this->dispositivos = $dispositivos;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }


}
