<?php

namespace Src\Application\DTO\ListCharacters;

use Src\Application\DTO\BaseDTO;

/**
 * Class ListCharactersOutput
 * 
 * Data Transfer Object for the output of a characters list.
 */
class ListCharactersOutput extends BaseDTO
{
    /**
     * @param string $id The ID of the character
     * @param string $name The name of the character 
     * @param string $humor The humor of the character 
     * @param string $role The role of the character 
     * @param string $ageVitality The age and vitality of the character 
     * @param string $origin The origin of the character 
     * @param string $speechMannerisms The speech mannerisms of the character 
     * @param string $accent The accent of the character 
     * @param string $archetype The archetype of the character 
     * @param string $imagePath The image path of the character 
     * @param string $color Color representation of the character 
     */
    public function __construct(
        readonly public string $id,
        readonly public string $name,
        readonly public string $humor,
        readonly public string $role,
        readonly public string $ageVitality,
        readonly public string $origin,
        readonly public string $speechMannerisms,
        readonly public string $accent,
        readonly public string $archetype,
        readonly public string $imagePath,
        readonly public string $color,
    ) {
    }

   
}
