<?php
class HashTag
{
    private $name;
    private $weight;
    //private $density;
    
    function __construct($name,$weight)
    {
        $this->name = $name;
        $this->weight = $weight;
    }
    
    public function getDensity()
    {
        return $this->density;
    }
    
    public function setDensity($density)
    {
        $this->density = $density;
    }


    function getName()
    {
        return $this->name;
    }

    function getWeight()
    {
        return $this->weight;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function setWeight($weight)
    {
        $this->weight = $weight;
    }

    function increamentWeightBy($value)
    {
        $this->weight += $value;
    }
}