import HttpClient, { Output } from '../../../../core/application/http/HttpClient';
import Character from '../../../../core/domain/Character';
import APICharacterGateway from '../../../../core/infra/gateway/APICharacterGateway';

describe('APICharacterGateway', () => {
    let apiCharacterGateway: APICharacterGateway;
    let mockHttpClient: HttpClient = new class Mock implements HttpClient {
        post(url: string, params: any, body: any): Promise<Output> {
            throw new Error('Method not implemented.');
        }
        delete(url: string, params: any): Promise<Output> {
            throw new Error('Method not implemented.');
        }
        put(url: string, params: any, body: any): Promise<Output> {
            throw new Error('Method not implemented.');
        }
        async get(url: string, params: any): Promise<Output> {

            const mockResponse = {
                success: true,
                status: 200,
                data: {
                    characters: [
                        {
                            id: '1',
                            name: 'Character Name',
                            humor: 'Happy',
                            role: 'Hero',
                            ageVitality: 30,
                            origin: 'Origin',
                            speechMannerisms: 'Polite',
                            accent: 'British',
                            archetype: 'Leader',
                            imagePath: '/path/to/image',
                            color: 'Blue',
                        },
                    ],
                },
            };
            return mockResponse;
        }

    };

    beforeEach(() => {
        apiCharacterGateway = new APICharacterGateway(mockHttpClient);
    });

    it('should list characters', async () => {
        const characters = await apiCharacterGateway.list();

        expect(characters.length).toBe(1);
        expect(characters[0]).toBeInstanceOf(Character);
        expect(characters[0].getId()).toBe('1');
        expect(characters[0].getName()).toBe('Character Name');
    });

    it('should handle error when listing characters', async () => {
        mockHttpClient.get = async (url: string, params: any): Promise<Output> => ({
            success: false,
            status: 500,
            data: {}
        });

        const characters = await apiCharacterGateway.list();

        expect(characters.length).toBe(0);
    });

});
