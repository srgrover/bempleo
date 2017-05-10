<?php

/**
 * Created by: Jonathan Moya Moreno
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Idioma{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $idioma;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $traduce;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $habla;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $escribe;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="idioma")
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
     * @return string
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * @param string $idioma
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;
    }

    /**
     * @return string
     */
    public function getTraduce()
    {
        return $this->traduce;
    }

    /**
     * @param string $traduce
     */
    public function setTraduce($traduce)
    {
        $this->traduce = $traduce;
    }

    /**
     * @return string
     */
    public function getHabla()
    {
        return $this->habla;
    }

    /**
     * @param string $habla
     */
    public function setHabla($habla)
    {
        $this->habla = $habla;
    }

    /**
     * @return string
     */
    public function getEscribe()
    {
        return $this->escribe;
    }

    /**
     * @param string $escribe
     */
    public function setEscribe($escribe)
    {
        $this->escribe = $escribe;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

}