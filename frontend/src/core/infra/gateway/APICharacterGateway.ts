import CharacterGateway from "../../application/gateway/CharacterGateway";
import HttpClient from "../../application/http/HttpClient";
import Character from "../../domain/Character";


export default class APICharacterGateway implements CharacterGateway {
    private endpoint: string = 'character';
    private apiUrl: string = 'http://localhost:9000/api/';

    constructor(
        private readonly httpClient: HttpClient
    ) {
    }

    async list(): Promise<Character[]> {
        const response = await this.httpClient.get(`${this.apiUrl}${this.endpoint}`, {});

        let characters: Character[] = [];
        if (response.success) {
            characters = response.data.characters.map((character: any) => {
                return new Character(
                    character.id,
                    character.name,
                    character.humor,
                    character.role,
                    character.ageVitality,
                    character.origin,
                    character.speechMannerisms,
                    character.accent,
                    character.archetype,
                    character.imagePath,
                    character.color,
                )
            });
        }
        return characters;
    }


}