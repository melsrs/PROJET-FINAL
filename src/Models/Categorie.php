<?php

namespace src\Models;

use src\Services\Hydratation;

class Categorie 
{
    private int $Id_Categorie;
        private string $type;

    use Hydratation; 

    /**
     * Get the value of Id_Categorie
     */
    public function getIdCategorie(): int
    {
        return $this->Id_Categorie;
    }

    /**
     * Set the value of Id_Categorie
     */
    public function setIdCategorie(int $Id_Categorie): self
    {
        $this->Id_Categorie = $Id_Categorie;

        return $this;
    }

        /**
         * Get the value of type
         */
        public function getType(): string
        {
                return $this->type;
        }

        /**
         * Set the value of type
         */
        public function setType(string $type): self
        {
                $this->type = $type;

                return $this;
        }
}