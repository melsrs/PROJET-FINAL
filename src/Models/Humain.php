<?php

namespace src\Models;

use src\Services\Hydratation;

class Humain
{
    private int $Id_Humain;
    private string $prenom;
    private string $nom;
    private string $age;
    private string $anniversaire;
    private string $taille;
    private string $affiliation;

    use Hydratation;

    /**
     * Get the value of Id_Humain
     */
    public function getIdHumain(): int
    {
        return $this->Id_Humain;
    }

    /**
     * Set the value of Id_Humain
     */
    public function setIdHumain(int $Id_Humain): self
    {
        $this->Id_Humain = $Id_Humain;

        return $this;
    }

    /**
     * Get the value of prenom
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     */
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of nom
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of age
     */
    public function getAge(): string
    {
        return $this->age;
    }

    /**
     * Set the value of age
     */
    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of anniversaire
     */
    public function getAnniversaire(): string
    {
        return $this->anniversaire;
    }

    /**
     * Set the value of anniversaire
     */
    public function setAnniversaire(string $anniversaire): self
    {
        $this->anniversaire = $anniversaire;

        return $this;
    }

    /**
     * Get the value of taille
     */
    public function getTaille(): string
    {
        return $this->taille;
    }

    /**
     * Set the value of taille
     */
    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * Get the value of affiliation
     */
    public function getAffiliation(): string
    {
        return $this->affiliation;
    }

    /**
     * Set the value of affiliation
     */
    public function setAffiliation(string $affiliation): self
    {
        $this->affiliation = $affiliation;

        return $this;
    }
}
