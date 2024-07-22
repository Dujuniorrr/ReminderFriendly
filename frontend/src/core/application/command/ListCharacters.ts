import Character from "../../domain/Character";
import CharacterGateway from "../gateway/CharacterGateway";

/**
 * @export
 * @class ListCharacters
 */
export default class ListCharacters {
    /**
     * Creates an instance of ListCharacters.
     * @param {CharacterGateway} characterGateway
     * @memberof ListCharacters
     */
    constructor(
        private readonly characterGateway: CharacterGateway
    ) { }

    /**
     * @param {Input} input
     * @return {*}  {Promise<Output[]>}
     * @memberof ListCharacters
     */
    public async execute(input: Input): Promise<Output[]> {
        const characters: Character[] = await this.characterGateway.list();
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