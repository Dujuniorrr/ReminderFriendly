<?php

namespace Src\Domain;

use DomainException;

class Character
{
    private string $id;

    public function __construct(
        readonly private string $name,
        readonly private string $humor,
        readonly private string $role,
        readonly private string $ageVitality,
        readonly private string $origin,
        readonly private string $speechMannerisms,
        readonly private string $accent,
        readonly private string $archetype,
        readonly private string $imagePath,
        readonly private string $color
    ) {
        if (empty($this->name)) throw new DomainException('Character name is required!');
        if (empty($this->humor)) throw new DomainException('Character humor is required!');
        if (empty($this->role)) throw new DomainException('Character role is required!');
        if (empty($this->ageVitality)) throw new DomainException('Character ageVitality is required!');
        if (empty($this->origin)) throw new DomainException('Character origin is required!');
        if (empty($this->speechMannerisms)) throw new DomainException('Character speechMannerisms is required!');
        if (empty($this->accent)) throw new DomainException('Character accent is required!');
        if (empty($this->archetype)) throw new DomainException('Character archetype is required!');
        if (empty($this->imagePath)) throw new DomainException('Character imagePath is required!');
        if (empty($this->color)) throw new DomainException('Character color is required!');
    }

    static function create(
        string $id,
        string $name,
        string $humor,
        string $role,
        string $ageVitality,
        string $origin,
        string $speechMannerisms,
        string $accent,
        string $archetype,
        string $imagePath,
        string $color
    ): self {
        $instance = new self(
            $name,
            $humor,
            $role,
            $ageVitality,
            $origin,
            $speechMannerisms,
            $accent,
            $archetype,
            $imagePath,
            $color
        );
        $instance->id = $id;
        return $instance;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of humor
     */
    public function getHumor()
    {
        return $this->humor;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the value of ageVitality
     */
    public function getAgeVitality()
    {
        return $this->ageVitality;
    }

    /**
     * Get the value of origin
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Get the value of speechMannerisms
     */
    public function getSpeechMannerisms()
    {
        return $this->speechMannerisms;
    }


    /**
     * Get the value of accent
     */
    public function getAccent()
    {
        return $this->accent;
    }

    /**
     * Get the value of archetype
     */
    public function getArchetype()
    {
        return $this->archetype;
    }

    /**
     * Get the value of imagePath
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Get the value of color
     */
    public function getColor()
    {
        return $this->color;
    }
}
