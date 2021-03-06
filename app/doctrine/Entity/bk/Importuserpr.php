<?php

namespace Entity;

/**
 * Importuserpr
 */
class Importuserpr
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
    private $Nome;

    /**
     * @var string
     */
    private $Sobrenome;

    /**
     * @var string
     */
    private $Email;

    /**
     * @var string
     */
    private $Relaocomasap;

    /**
     * @var string
     */
    private $Empresa;

    /**
     * @var string
     */
    private $Indstria;

    /**
     * @var string
     */
    private $Cargo;

    /**
     * @var string
     */
    private $Telefone;

    /**
     * @var string
     */
    private $Cidade;

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
     * @return Importuserpr
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
     * @return Importuserpr
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
     * @return Importuserpr
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
     * Set nome
     *
     * @param string $nome
     *
     * @return Importuserpr
     */
    public function setNome($nome)
    {
        $this->Nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->Nome;
    }

    /**
     * Set sobrenome
     *
     * @param string $sobrenome
     *
     * @return Importuserpr
     */
    public function setSobrenome($sobrenome)
    {
        $this->Sobrenome = $sobrenome;

        return $this;
    }

    /**
     * Get sobrenome
     *
     * @return string
     */
    public function getSobrenome()
    {
        return $this->Sobrenome;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Importuserpr
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
     * Set relaocomasap
     *
     * @param string $relaocomasap
     *
     * @return Importuserpr
     */
    public function setRelaocomasap($relaocomasap)
    {
        $this->Relaocomasap = $relaocomasap;

        return $this;
    }

    /**
     * Get relaocomasap
     *
     * @return string
     */
    public function getRelaocomasap()
    {
        return $this->Relaocomasap;
    }

    /**
     * Set empresa
     *
     * @param string $empresa
     *
     * @return Importuserpr
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
     * Set indstria
     *
     * @param string $indstria
     *
     * @return Importuserpr
     */
    public function setIndstria($indstria)
    {
        $this->Indstria = $indstria;

        return $this;
    }

    /**
     * Get indstria
     *
     * @return string
     */
    public function getIndstria()
    {
        return $this->Indstria;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     *
     * @return Importuserpr
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
     * Set telefone
     *
     * @param string $telefone
     *
     * @return Importuserpr
     */
    public function setTelefone($telefone)
    {
        $this->Telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone
     *
     * @return string
     */
    public function getTelefone()
    {
        return $this->Telefone;
    }

    /**
     * Set cidade
     *
     * @param string $cidade
     *
     * @return Importuserpr
     */
    public function setCidade($cidade)
    {
        $this->Cidade = $cidade;

        return $this;
    }

    /**
     * Get cidade
     *
     * @return string
     */
    public function getCidade()
    {
        return $this->Cidade;
    }

    /**
     * Set pais
     *
     * @param string $pais
     *
     * @return Importuserpr
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
     * @return Importuserpr
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
     * @return Importuserpr
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
     * @return Importuserpr
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
     * @return Importuserpr
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
     * @return Importuserpr
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
     * @return Importuserpr
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
     * @return Importuserpr
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
     * @return Importuserpr
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
     * @return Importuserpr
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
     * @return Importuserpr
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
    private $Relaccedilaocomasap;


    /**
     * Set relaccedilaocomasap
     *
     * @param string $relaccedilaocomasap
     *
     * @return Importuserpr
     */
    public function setRelaccedilaocomasap($relaccedilaocomasap)
    {
        $this->Relaccedilaocomasap = $relaccedilaocomasap;

        return $this;
    }

    /**
     * Get relaccedilaocomasap
     *
     * @return string
     */
    public function getRelaccedilaocomasap()
    {
        return $this->Relaccedilaocomasap;
    }
    /**
     * @var string
     */
    private $Industria;


    /**
     * Set industria
     *
     * @param string $industria
     *
     * @return Importuserpr
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
     * @var string
     */
     private $Slug;
     
     
         /**
          * Set slug
          *
          * @param string $slug
          *
          * @return Importuser
          */
         public function setSlug($Slug)
         {
             $this->Slug = $Slug;
     
             return $this;
         }
     
         /**
          * Get slug
          *
          * @return string
          */
         public function getSlug()
         {
             return $this->Slug;
         }


}
