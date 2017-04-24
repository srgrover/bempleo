<?php

/**
 * Created by: Jonathan Moya Moreno
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Laboral{

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
    private $empresa;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $actividad;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $puesto;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $tareas;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $fecha_inicio;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $fecha_fin;

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
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param string $empresa
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
    }

    /**
     * @return string
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * @param string $actividad
     */
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;
    }

    /**
     * @return string
     */
    public function getPuesto()
    {
        return $this->puesto;
    }

    /**
     * @param string $puesto
     */
    public function setPuesto($puesto)
    {
        $this->puesto = $puesto;
    }

    /**
     * @return string
     */
    public function getTareas()
    {
        return $this->tareas;
    }

    /**
     * @param string $tareas
     */
    public function setTareas($tareas)
    {
        $this->tareas = $tareas;
    }

    /**
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * @param \DateTime $fecha_inicio
     */
    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    /**
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
    }

    /**
     * @param \DateTime $fecha_fin
     */
    public function setFechaFin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;
    }
}