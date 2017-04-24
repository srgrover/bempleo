<?php

/**
 * Created by: Jonathan Moya Moreno
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Informatica{

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
    private $campo;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $nivel;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $programas_maneja;

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
    public function getCampo()
    {
        return $this->campo;
    }

    /**
     * @param string $campo
     */
    public function setCampo($campo)
    {
        $this->campo = $campo;
    }

    /**
     * @return string
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @param string $nivel
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }

    /**
     * @return string
     */
    public function getProgramasManeja()
    {
        return $this->programas_maneja;
    }

    /**
     * @param string $programas_maneja
     */
    public function setProgramasManeja($programas_maneja)
    {
        $this->programas_maneja = $programas_maneja;
    }
}