<?php

/**
 * Created by: Jonathan Moya Moreno
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Formacion{

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
    private $nombre_centro;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $titulacion;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $especialidad;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $obtencion;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $nivel_academico;

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
    public function getNombreCentro()
    {
        return $this->nombre_centro;
    }

    /**
     * @param string $nombre_centro
     */
    public function setNombreCentro($nombre_centro)
    {
        $this->nombre_centro = $nombre_centro;
    }

    /**
     * @return string
     */
    public function getTitulacion()
    {
        return $this->titulacion;
    }

    /**
     * @param string $titulacion
     */
    public function setTitulacion($titulacion)
    {
        $this->titulacion = $titulacion;
    }

    /**
     * @return string
     */
    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    /**
     * @param string $especialidad
     */
    public function setEspecialidad($especialidad)
    {
        $this->especialidad = $especialidad;
    }

    /**
     * @return \DateTime
     */
    public function getObtencion()
    {
        return $this->obtencion;
    }

    /**
     * @param \DateTime $obtencion
     */
    public function setObtencion($obtencion)
    {
        $this->obtencion = $obtencion;
    }

    /**
     * @return string
     */
    public function getNivelAcademico()
    {
        return $this->nivel_academico;
    }

    /**
     * @param string $nivel_academico
     */
    public function setNivelAcademico($nivel_academico)
    {
        $this->nivel_academico = $nivel_academico;
    }

}