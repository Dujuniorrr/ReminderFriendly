import Character from "../../domain/Character";
import CharacterGateway from "../gateway/CharacterGateway";

/**
 * @export
 * @class ListCharacters
 */
export default class ListCharacters {
    /**
     * Creates an instance of ListCharacters.
     * @param {CharacterGateway} characterGteway
     * @memberof ListCharacters
     */
    constructor(
        private readonly characterGteway: CharacterGateway
    ) { }

    /**
     * @param {Input} input
     * @return {*}  {Promise<Output[]>}
     * @memberof ListCharacters
     */
    public async execute(input: Input): Promise<Output[]> {
        const characters: Character[] = await this.characterGteway.list();
        const output: Output[] = characters.map((character: Character) => {
            return {
                id: character.getId(),
                name: character.getName(),
                imagePath: character.getImagePath(),
                color: character.getColor()
            }
        })
        return output;
    }
}

type Input = {
 
}

export type Output = {
    id: string,
    name: string,
    imagePath: string,
    color: string
}