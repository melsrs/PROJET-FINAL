<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class Article 
{
    private int $Id_Article;
        private string $titre;
        private string $texte;
        private DateTime $date;
        private string $image;

    use Hydratation; 

    /**
     * Get the value of Id_Article
     */
    public function getIdArticle(): int
    {
        return $this->Id_Article;
    }

    /**
     * Set the value of Id_Article
     */
    public function setIdArticle(int $Id_Article): self
    {
        $this->Id_Article = $Id_Article;

        return $this;
    }

        /**
         * Get the value of titre
         */
        public function getTitre(): string
        {
                return $this->titre;
        }

        /**
         * Set the value of titre
         */
        public function setTitre(string $titre): self
        {
                $this->titre = $titre;

                return $this;
        }

        /**
         * Get the value of texte
         */
        public function getTexte(): string
        {
                return $this->texte;
        }

        /**
         * Set the value of texte
         */
        public function setTexte(string $texte): self
        {
                $this->texte = $texte;

                return $this;
        }

        /**
         * Get the value of date
         */
        public function getDate(): DateTime
        {
                return $this->date;
        }

        /**
         * Set the value of date
         */
        public function setDate(DateTime $date): self
        {
                $this->date = $date;

                return $this;
        }

        /**
         * Get the value of image
         */
        public function getImage(): string
        {
                return $this->image;
        }

        /**
         * Set the value of image
         */
        public function setImage(string $image): self
        {
                $this->image = $image;

                return $this;
        }
}