<?php

namespace src\Models;

use src\Services\Hydratation;

class Titan 
{
    private int $Id_Titan;
        private string $nom;
        private string $taille;
        private string $pouvoir;
        private string $allegeance;
        private string $detenteur_actuel;
        private string $ancien_detenteur;

    use Hydratation; 

    /**
     * Get the value of Id_Titan
     */
    public function getIdTitan(): int
    {
        return $this->Id_Titan;
    }

    /**
     * Set the value of Id_Titan
     */
    public function setIdTitan(int $Id_Titan): self
    {
        $this->Id_Titan = $Id_Titan;

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
         * Get the value of pouvoir
         */
        public function getPouvoir(): string
        {
                return $this->pouvoir;
        }

        /**
         * Set the value of pouvoir
         */
        public function setPouvoir(string $pouvoir): self
        {
                $this->pouvoir = $pouvoir;

                return $this;
        }

        /**
         * Get the value of allegeance
         */
        public function getAllegeance(): string
        {
                return $this->allegeance;
        }

        /**
         * Set the value of allegeance
         */
        public function setAllegeance(string $allegeance): self
        {
                $this->allegeance = $allegeance;

                return $this;
        }

        /**
         * Get the value of detenteur_actuel
         */
        public function getDetenteurActuel(): string
        {
                return $this->detenteur_actuel;
        }

        /**
         * Set the value of detenteur_actuel
         */
        public function setDetenteurActuel(string $detenteur_actuel): self
        {
                $this->detenteur_actuel = $detenteur_actuel;

                return $this;
        }

        /**
         * Get the value of ancien_detenteur
         */
        public function getAncienDetenteur(): string
        {
                return $this->ancien_detenteur;
        }

        /**
         * Set the value of ancien_detenteur
         */
        public function setAncienDetenteur(string $ancien_detenteur): self
        {
                $this->ancien_detenteur = $ancien_detenteur;

                return $this;
        }
}