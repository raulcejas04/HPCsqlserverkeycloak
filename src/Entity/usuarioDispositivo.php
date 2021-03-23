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
class usuarioDispositivo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="dispositivos", inversedBy="usuarioDispositivo")
     * @ORM\JoinColumn(name="id_dispositivo_hpc", referencedColumnName="id_dispositivo_hpc")
    */
    private $dispositivos;
    //private $idDispositivoHpc;

    /**
     * @ORM\ManyToOne(targetEntity="usuario", inversedBy="usuarioDispositivo")
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

    public function getDispositivos(): ?dispositivos
    {
        return $this->dispositivos;
    }

    public function setDispositivos(?dispositivos $dispositivos): self
    {
        $this->dispositivos = $dispositivos;

        return $this;
    }

    public function getUsuario(): ?usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }


}
