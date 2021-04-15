<?php
namespace App\Entity;

class Search{
    private $motCle;

    /**
     * Get the value of motCle
     */ 
    public function getMotCle()
    {
        return $this->motCle;
    }

    /**
     * Set the value of motCle
     *
     * @return  self
     */ 
    public function setMotCle($motCle)
    {
        $this->motCle = $motCle;

        return $this;
    }
}