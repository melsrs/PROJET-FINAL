<?php

namespace src\Models;

use src\Services\Hydratation;

class Role
{
    private int $Id_Role;
    private string $type;

    use Hydratation;

    /**
     * Get the value of Id_Role
     */
    public function getIdRole(): int
    {
        return $this->Id_Role;
    }

    /**
     * Set the value of Id_Role
     */
    public function setIdRole(int $Id_Role): self
    {
        $this->Id_Role = $Id_Role;

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
