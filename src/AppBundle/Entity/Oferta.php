<?php

/**
 * Created by: Jonathan Moya Moreno
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Oferta{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $vigente;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $revisado;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $inhabilitado;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="oferta")
     *
     * @var Usuario
     */
    protected $usuario;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isVigente()
    {
        return $this->vigente;
    }

    /**
     * @param bool $vigente
     */
    public function setVigente($vigente)
    {
        $this->vigente = $vigente;
    }

    /**
     * @return bool
     */
    public function isRevisado()
    {
        return $this->revisado;
    }

    /**
     * @param bool $revisado
     */
    public function setRevisado($revisado)
    {
        $this->revisado = $revisado;
    }

    /**
     * @return bool
     */
    public function isInhabilitado()
    {
        return $this->inhabilitado;
    }

    /**
     * @param bool $inhabilitado
     */
    public function setInhabilitado($inhabilitado)
    {
        $this->inhabilitado = $inhabilitado;
    }

}