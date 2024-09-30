<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class Article
{
        private int $Id_Article;
        private string $titre;
        private string $texte;
        private string|DateTime $date;
        private string $image;
        private int $Id_Categorie;
        private int $Id_Utilisateur;

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
        public function setDate(string|DateTime $date): self
        {
                if ($date instanceof DateTime) {
                        $this->date = $date;
                } else {
                        $this->date = new DateTime($date);
                }

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
}
