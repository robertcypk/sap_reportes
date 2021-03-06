<?php

namespace Entity;

/**
 * Importuser
 */
class Importuser
{
    /**
     * @var integer
     */
    private $idoption;

    /**
     * @var string
     */
    private $Titulo;

    /**
     * @var string
     */
    private $Idioma;

    /**
     * @var string
     */
    private $Categoria;

    /**
     * @var string
     */
    private $Nombre;

    /**
     * @var string
     */
    private $Apellido;

    /**
     * @var string
     */
    private $Email;

    /**
     * @var string
     */
    private $Relacinconsap;

    /**
     * @var string
     */
    private $Empresa;

    /**
     * @var string
     */
    private $Industria;

    /**
     * @var string
     */
    private $Cargo;

    /**
     * @var string
     */
    private $Telfonodelaempresa;

    /**
     * @var string
     */
    private $Ciudad;

    /**
     * @var string
     */
    private $Pais;

    /**
     * @var string
     */
    private $Attendedlive;

    /**
     * @var string
     */
    private $Pregunta1;

    /**
     * @var string
     */
    private $Pregunta2;

    /**
     * @var string
     */
    private $Pregunta3;

    /**
     * @var string
     */
    private $Pregunta4;

    /**
     * @var string
     */
    private $Pregunta5;

    /**
     * @var string
     */
    private $Pregunta6;

    /**
     * @var string
     */
    private $Pregunta7;

    /**
     * @var string
     */
    private $Pregunta8;

    /**
     * @var string
     */
    private $Fecha;

    /**
     * @var integer
     */
    private $Idreport;



    /**
     * Get idoption
     *
     * @return integer
     */
    public function getIdoption()
    {
        return $this->idoption;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Importuser
     */
    public function setTitulo($titulo)
    {
        $this->Titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->Titulo;
    }

    /**
     * Set idioma
     *
     * @param string $idioma
     *
     * @return Importuser
     */
    public function setIdioma($idioma)
    {
        $this->Idioma = $idioma;

        return $this;
    }

    /**
     * Get idioma
     *
     * @return string
     */
    public function getIdioma()
    {
        return $this->Idioma;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     *
     * @return Importuser
     */
    public function setCategoria($categoria)
    {
        $this->Categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->Categoria;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Importuser
     */
    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Importuser
     */
    public function setApellido($apellido)
    {
        $this->Apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->Apellido;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Importuser
     */
    public function setEmail($email)
    {
        $this->Email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * Set relacinconsap
     *
     * @param string $relacinconsap
     *
     * @return Importuser
     */
    public function setRelacinconsap($relacinconsap)
    {
        $this->Relacinconsap = $relacinconsap;

        return $this;
    }

    /**
     * Get relacinconsap
     *
     * @return string
     */
    public function getRelacinconsap()
    {
        return $this->Relacinconsap;
    }

    /**
     * Set empresa
     *
     * @param string $empresa
     *
     * @return Importuser
     */
    public function setEmpresa($empresa)
    {
        $this->Empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string
     */
    public function getEmpresa()
    {
        return $this->Empresa;
    }

    /**
     * Set industria
     *
     * @param string $industria
     *
     * @return Importuser
     */
    public function setIndustria($industria)
    {
        $this->Industria = $industria;

        return $this;
    }

    /**
     * Get industria
     *
     * @return string
     */
    public function getIndustria()
    {
        return $this->Industria;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     *
     * @return Importuser
     */
    public function setCargo($cargo)
    {
        $this->Cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->Cargo;
    }

    /**
     * Set telfonodelaempresa
     *
     * @param string $telfonodelaempresa
     *
     * @return Importuser
     */
    public function setTelfonodelaempresa($telfonodelaempresa)
    {
        $this->Telfonodelaempresa = $telfonodelaempresa;

        return $this;
    }

    /**
     * Get telfonodelaempresa
     *
     * @return string
     */
    public function getTelfonodelaempresa()
    {
        return $this->Telfonodelaempresa;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     *
     * @return Importuser
     */
    public function setCiudad($ciudad)
    {
        $this->Ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string
     */
    public function getCiudad()
    {
        return $this->Ciudad;
    }

    /**
     * Set pais
     *
     * @param string $pais
     *
     * @return Importuser
     */
    public function setPais($pais)
    {
        $this->Pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais()
    {
        return $this->Pais;
    }

    /**
     * Set attendedlive
     *
     * @param string $attendedlive
     *
     * @return Importuser
     */
    public function setAttendedlive($attendedlive)
    {
        $this->Attendedlive = $attendedlive;

        return $this;
    }

    /**
     * Get attendedlive
     *
     * @return string
     */
    public function getAttendedlive()
    {
        return $this->Attendedlive;
    }

    /**
     * Set pregunta1
     *
     * @param string $pregunta1
     *
     * @return Importuser
     */
    public function setPregunta1($pregunta1)
    {
        $this->Pregunta1 = $pregunta1;

        return $this;
    }

    /**
     * Get pregunta1
     *
     * @return string
     */
    public function getPregunta1()
    {
        return $this->Pregunta1;
    }

    /**
     * Set pregunta2
     *
     * @param string $pregunta2
     *
     * @return Importuser
     */
    public function setPregunta2($pregunta2)
    {
        $this->Pregunta2 = $pregunta2;

        return $this;
    }

    /**
     * Get pregunta2
     *
     * @return string
     */
    public function getPregunta2()
    {
        return $this->Pregunta2;
    }

    /**
     * Set pregunta3
     *
     * @param string $pregunta3
     *
     * @return Importuser
     */
    public function setPregunta3($pregunta3)
    {
        $this->Pregunta3 = $pregunta3;

        return $this;
    }

    /**
     * Get pregunta3
     *
     * @return string
     */
    public function getPregunta3()
    {
        return $this->Pregunta3;
    }

    /**
     * Set pregunta4
     *
     * @param string $pregunta4
     *
     * @return Importuser
     */
    public function setPregunta4($pregunta4)
    {
        $this->Pregunta4 = $pregunta4;

        return $this;
    }

    /**
     * Get pregunta4
     *
     * @return string
     */
    public function getPregunta4()
    {
        return $this->Pregunta4;
    }

    /**
     * Set pregunta5
     *
     * @param string $pregunta5
     *
     * @return Importuser
     */
    public function setPregunta5($pregunta5)
    {
        $this->Pregunta5 = $pregunta5;

        return $this;
    }

    /**
     * Get pregunta5
     *
     * @return string
     */
    public function getPregunta5()
    {
        return $this->Pregunta5;
    }

    /**
     * Set pregunta6
     *
     * @param string $pregunta6
     *
     * @return Importuser
     */
    public function setPregunta6($pregunta6)
    {
        $this->Pregunta6 = $pregunta6;

        return $this;
    }

    /**
     * Get pregunta6
     *
     * @return string
     */
    public function getPregunta6()
    {
        return $this->Pregunta6;
    }

    /**
     * Set pregunta7
     *
     * @param string $pregunta7
     *
     * @return Importuser
     */
    public function setPregunta7($pregunta7)
    {
        $this->Pregunta7 = $pregunta7;

        return $this;
    }

    /**
     * Get pregunta7
     *
     * @return string
     */
    public function getPregunta7()
    {
        return $this->Pregunta7;
    }

    /**
     * Set pregunta8
     *
     * @param string $pregunta8
     *
     * @return Importuser
     */
    public function setPregunta8($pregunta8)
    {
        $this->Pregunta8 = $pregunta8;

        return $this;
    }

    /**
     * Get pregunta8
     *
     * @return string
     */
    public function getPregunta8()
    {
        return $this->Pregunta8;
    }

    /**
     * Set fecha
     *
     * @param string $fecha
     *
     * @return Importuser
     */
    public function setFecha($fecha)
    {
        $this->Fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return string
     */
    public function getFecha()
    {
        return $this->Fecha;
    }
    /**
     * @var string
     */
    private $Relacionconsap;


    /**
     * Set relacionconsap
     *
     * @param string $relacionconsap
     *
     * @return Importuser
     */
    public function setRelacionconsap($relacionconsap)
    {
        $this->Relacionconsap = $relacionconsap;

        return $this;
    }

    /**
     * Get relacionconsap
     *
     * @return string
     */
    public function getRelacionconsap()
    {
        return $this->Relacionconsap;
    }
    /**
     * @var string
     */
    private $Telefonodelaempresa;


    /**
     * Set telefonodelaempresa
     *
     * @param string $telefonodelaempresa
     *
     * @return Importuser
     */
    public function setTelefonodelaempresa($telefonodelaempresa)
    {
        $this->Telefonodelaempresa = $telefonodelaempresa;

        return $this;
    }

    /**
     * Get telefonodelaempresa
     *
     * @return string
     */
    public function getTelefonodelaempresa()
    {
        return $this->Telefonodelaempresa;
    }
    /**
     * @var string
     */
    private $Slug;


    /**
     * Set Idreport
     *
     * @param string $Idreport
     *
     * @return Importuser
     */
    public function setIdreport($Idreport)
    {
        $this->Idreport = $Idreport;

        return $this;
    }

    /**
     * Get Idreport
     *
     * @return string
     */
    public function getIdreport()
    {
        return $this->Idreport;
    }

}
