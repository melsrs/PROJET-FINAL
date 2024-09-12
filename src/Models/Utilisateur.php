<?php

namespace src\Models;

use src\Services\Hydratation;

class Utilisateur
{
    private int $Id_Utilisateur;
    private string $prenom;
    private string $nom;
    private string $mail;
    private string $mdp;

    use Hydratation;

    /**
     * Get the value of Id_Utilisateur
     */
    public function getIdUtilisateur(): int
    {
        return $this->Id_Utilisateur;
    }

    /**
     * Set the value of Id_Utilisateur
     */
    public function setIdUtilisateur(int $Id_Utilisateur): self
    {
        $this->Id_Utilisateur = $Id_Utilisateur;

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
     * Get the value of mail
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     */
    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of mdp
     */
    public function getMdp(): string
    {
        return $this->mdp;
    }

    /**
     * Set the value of mdp
     */
    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }
}
