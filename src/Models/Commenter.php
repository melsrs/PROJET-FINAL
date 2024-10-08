<?php

namespace src\Models;

use DateTime;
use src\Services\Hydratation;

class Commenter
{
    private int $Id_Article;
    private int $Id_Utilisateur;
    private string $message;
    private string|DateTime $date_commentaire;
    private bool $valide;

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

    /**
     * Get the value of message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set the value of message
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of date_commentaire
     */
    public function getDateCommentaire(): DateTime
    {
        if (!$this->date_commentaire instanceof DateTime) {
            $this->date_commentaire = new DateTime($this->date_commentaire);
        }
        return $this->date_commentaire;
    }

    /**
     * Set the value of date_commentaire
     */
    public function setDateCommentaire(string|DateTime $date_commentaire): self
    {
        if ($date_commentaire instanceof DateTime) {
            $this->date_commentaire = $date_commentaire;
        } else {
            $this->date_commentaire = new DateTime($date_commentaire);
        }

        return $this;
    }

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
     * Get the value of valide
     */
    public function isValide(): bool
    {
        return $this->valide;
    }

    /**
     * Set the value of valide
     */
    public function setValide(bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }
}
