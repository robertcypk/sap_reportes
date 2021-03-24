<?php

namespace Entity;

/**
 * Options
 */
class Options
{
    /**
     * @var integer
     */
    private $idoption;

    /**
     * @var string
     */
    private $input;

    /**
     * @var string
     */
    private $val;


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
     * Set input
     *
     * @param string $input
     *
     * @return Options
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get input
     *
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set val
     *
     * @param string $val
     *
     * @return Options
     */
    public function setVal($val)
    {
        $this->val = $val;

        return $this;
    }

    /**
     * Get val
     *
     * @return string
     */
    public function getVal()
    {
        return $this->val;
    }
}
