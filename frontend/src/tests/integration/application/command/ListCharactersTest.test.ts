import ListCharacters from "../../../../core/application/command/ListCharacters";
import CharacterGateway from "../../../../core/application/gateway/CharacterGateway";
import HttpClient from "../../../../core/application/http/HttpClient";
import APICharacterGateway from "../../../../core/infra/gateway/APICharacterGateway";
import AxiosHttpClient from "../../../../core/infra/http/AxiosHttpClient";

test('must return a list of characters', async () => {
    const httpClient: HttpClient = new AxiosHttpClient();
    const characterGteway: CharacterGateway = new APICharacterGateway(httpClient);
    const listCharacters = new ListCharacters(characterGteway);

    const output = await listCharacters.execute({});

    expect(output.length).toBeLessThanOrEqual(20);
});