<?php

namespace src\Models;

use src\Services\Hydratation;

class Likes
{
    private int $Id_Article;
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