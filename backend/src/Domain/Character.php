<?php

namespace Src\Domain;

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
        readonly private string $imagePath
    ) {
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
        string $imagePath
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
            $imagePath
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
}
