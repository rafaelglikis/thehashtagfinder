<?php

class HashTag
{
    private $name;
    private $weight;

    function __construct($name,$weight=0)
    {
        $this->name = $name;
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