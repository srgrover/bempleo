<?php

/**
 * Created by: Jonathan Moya Moreno
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
// Acme/TaskBundle/Entity/Task.php
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Usuario implements UserInterface{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $tipo_doc;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $num_identi;

    /**
     * @ORM\Column(type="string")
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="8",
     *     minMessage="La contraseña debe tener al menos 8 carácteres"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string")
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Un nombre no puede contener un dígito"
     * )
     */
    private $nombre;
    /**
     * @ORM\Column(type="string")
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Un apellido no puede contener un dígito"
     * )
     */
    private $apellidos;

    /**
     * @ORM\Column(type="string")
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $domicilio;

    /**
     * @ORM\Column(type="string")
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="La población no puede contener un dígito"
     * )
     */
    private $poblacion;

    /**
     * @ORM\Column(type="string")
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="La provincia no puede contener un dígito"
     * )
     */
    private $provincia;

    /**
     * @ORM\Column(type="string")
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="5",
     *     max="5",
     *     exactMessage="El código postal debe tener 5 dígitos"
     * )
     */
    private $cod_postal;

    /**
     * @ORM\Column(type="string")
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="El país no puede contener números"
     * )
     */
    private $pais;

    ///(\+34|0034|34)?[ -]*(9|6|7)[ -]*([0-9][ -]*){8}/
    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     *
     * @Assert\Length(
     *     min="9",
     *     max="9",
     *     exactMessage="El número de teléfono debe tener 9 dígitos"
     * )
     */
    private $movil;

    /**
     * @ORM\Column(type="string")
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="9",
     *     max="9",
     *     exactMessage="El número de teléfono debe tener 9 dígitos"
     * )
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/[\+? *[1-9]+]?[0-9 ]/+",
     *     match=false,
     *     message="El número de fax no esta admitido"
     * )
     */
    private $fax;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     *
     * @Assert\Email(
     *     message="El email '{{ value }} no es válido'",
     *     checkMX=true
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     * @var \DateTime
     *
     * @Assert\Type("\DateTime")
     */
    private $fecha_nac;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $sexo;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $estado_civil;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $hijos;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $carne_conducir;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $clase_carne;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $vehiculo_propio;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $nivel_academico;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $situ_laboral;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $disp_cambio_domicilio;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $disp_viajar;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $foto;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $horario_trabajo;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $pref_ocupacion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Formacion", mappedBy="usuario")
     *
     * @var Formacion
     */
    protected $formacion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Fcomplementaria", mappedBy="usuario")
     *
     * @var Fcomplementaria
     */
    protected $formacion_complem;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Laboral", mappedBy="usuario")
     *
     * @var Laboral
     */
    protected $laboral;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Oferta", mappedBy="usuario")
     *
     * @var Oferta
     */
    protected $oferta;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Idioma", mappedBy="usuario")
     *
     * @var Idioma
     */
    protected $idioma;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Informatica", mappedBy="usuario")
     *
     * @var Informatica
     */
    protected $informatica;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $admin = false;

    //Implementacion de la interfaz de roles
    public function equals(UserInterface $users){
        return $this->getEmail()==$users->getUsername();
    }

    public function eraseCredentials() {
        return false;
    }

    public function getRoles() {
        $roles = ["ROLE_USER"];     //Todos los usuarios son ROLE_USER
        if($this->isAdmin()){
            $roles[] = "ROLE_ADMIN";
        }
        return $roles;
    }

    public function getUsername() {
        return $this->getEmail();
    }

    public function getSalt() {
        return false;
    }
    //Fin de la definicion de clases de la interface de roles

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
    public function getTipoDoc()
    {
        return $this->tipo_doc;
    }

    /**
     * @param string $tipo_doc
     */
    public function setTipoDoc($tipo_doc)
    {
        $this->tipo_doc = $tipo_doc;
    }

    /**
     * @return string
     */
    public function getNumIdenti()
    {
        return $this->num_identi;
    }

    /**
     * @param string $num_identi
     */
    public function setNumIdenti($num_identi)
    {
        $this->num_identi = $num_identi;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * @param string $domicilio
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
    }

    /**
     * @return string
     */
    public function getPoblacion()
    {
        return $this->poblacion;
    }

    /**
     * @param string $poblacion
     */
    public function setPoblacion($poblacion)
    {
        $this->poblacion = $poblacion;
    }

    /**
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * @param string $provincia
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }

    /**
     * @return string
     */
    public function getCodPostal()
    {
        return $this->cod_postal;
    }

    /**
     * @param string $cod_postal
     */
    public function setCodPostal($cod_postal)
    {
        $this->cod_postal = $cod_postal;
    }

    /**
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param string $pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    /**
     * @return string
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * @param string $movil
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return \DateTime
     */
    public function getFechaNac()
    {
        return $this->fecha_nac;
    }

    /**
     * @param \DateTime $fecha_nac
     */
    public function setFechaNac($fecha_nac)
    {
        $this->fecha_nac = $fecha_nac;
    }

    /**
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param string $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * @return string
     */
    public function getEstadoCivil()
    {
        return $this->estado_civil;
    }

    /**
     * @param string $estado_civil
     */
    public function setEstadoCivil($estado_civil)
    {
        $this->estado_civil = $estado_civil;
    }

    /**
     * @return bool
     */
    public function isHijos()
    {
        return $this->hijos;
    }

    /**
     * @param bool $hijos
     */
    public function setHijos($hijos)
    {
        $this->hijos = $hijos;
    }

    /**
     * @return bool
     */
    public function isCarneConducir()
    {
        return $this->carne_conducir;
    }

    /**
     * @param bool $carne_conducir
     */
    public function setCarneConducir($carne_conducir)
    {
        $this->carne_conducir = $carne_conducir;
    }

    /**
     * @return string
     */
    public function getClaseCarne()
    {
        return $this->clase_carne;
    }

    /**
     * @param string $clase_carne
     */
    public function setClaseCarne($clase_carne)
    {
        $this->clase_carne = $clase_carne;
    }

    /**
     * @return bool
     */
    public function isVehiculoPropio()
    {
        return $this->vehiculo_propio;
    }

    /**
     * @param bool $vehiculo_propio
     */
    public function setVehiculoPropio($vehiculo_propio)
    {
        $this->vehiculo_propio = $vehiculo_propio;
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

    /**
     * @return string
     */
    public function getSituLaboral()
    {
        return $this->situ_laboral;
    }

    /**
     * @param string $situ_laboral
     */
    public function setSituLaboral($situ_laboral)
    {
        $this->situ_laboral = $situ_laboral;
    }

    /**
     * @return bool
     */
    public function isDispCambioDomicilio()
    {
        return $this->disp_cambio_domicilio;
    }

    /**
     * @param bool $disp_cambio_domicilio
     */
    public function setDispCambioDomicilio($disp_cambio_domicilio)
    {
        $this->disp_cambio_domicilio = $disp_cambio_domicilio;
    }

    /**
     * @return bool
     */
    public function isDispViajar()
    {
        return $this->disp_viajar;
    }

    /**
     * @param bool $disp_viajar
     */
    public function setDispViajar($disp_viajar)
    {
        $this->disp_viajar = $disp_viajar;
    }

    /**
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param string $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    /**
     * @return string
     */
    public function getHorarioTrabajo()
    {
        return $this->horario_trabajo;
    }

    /**
     * @param string $horario_trabajo
     */
    public function setHorarioTrabajo($horario_trabajo)
    {
        $this->horario_trabajo = $horario_trabajo;
    }

    /**
     * @return string
     */
    public function getPrefOcupacion()
    {
        return $this->pref_ocupacion;
    }

    /**
     * @param string $pref_ocupacion
     */
    public function setPrefOcupacion($pref_ocupacion)
    {
        $this->pref_ocupacion = $pref_ocupacion;
    }

    /**
     * @return Formacion
     */
    public function getFormacion()
    {
        return $this->formacion;
    }

    /**
     * @param Formacion $formacion
     */
    public function setFormacion($formacion)
    {
        $this->formacion = $formacion;
    }

    /**
     * @return Fcomplementaria
     */
    public function getFormacionComplem()
    {
        return $this->formacion_complem;
    }

    /**
     * @param Fcomplementaria $formacion_complem
     */
    public function setFormacionComplem($formacion_complem)
    {
        $this->formacion_complem = $formacion_complem;
    }

    /**
     * @return Laboral
     */
    public function getLaboral()
    {
        return $this->laboral;
    }

    /**
     * @param Laboral $laboral
     */
    public function setLaboral($laboral)
    {
        $this->laboral = $laboral;
    }

    /**
     * @return Oferta
     */
    public function getOferta()
    {
        return $this->oferta;
    }

    /**
     * @param Oferta $oferta
     */
    public function setOferta($oferta)
    {
        $this->oferta = $oferta;
    }

    /**
     * @return Idioma
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * @param Idioma $idioma
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;
    }

    /**
     * @return Informatica
     */
    public function getInformatica()
    {
        return $this->informatica;
    }

    /**
     * @param Informatica $informatica
     */
    public function setInformatica($informatica)
    {
        $this->informatica = $informatica;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @param bool $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

}