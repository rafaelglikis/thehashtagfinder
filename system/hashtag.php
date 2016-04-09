<?php
class HashTag
{
    private $name;
    private $weight;
    
    public function __construct($name,$weight)
    {
        $this->name = $name;
        $this->weight = $weight;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function increamentWeightBy($value)
    {
        $this->weight += $value;
    }
}