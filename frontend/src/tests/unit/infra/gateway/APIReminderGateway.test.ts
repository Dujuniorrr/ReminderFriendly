import HttpClient, { Output } from '../../../../core/application/http/HttpClient';
import Character from '../../../../core/domain/Character';
import Reminder from '../../../../core/domain/Reminder';
import APIReminderGateway from '../../../../core/infra/gateway/APIReminderGateway';


describe('APIReminderGateway', () => {
    let apiReminderGateway: APIReminderGateway;
    let mockHttpClient: HttpClient = new class Mock implements HttpClient {
        async get(url: string, params: any): Promise<Output> {
            const mockResponse = {
                success: true,
                status: 200,
                data: {
                    reminders: [
                        {
                            id: '1',
                            originalMessage: 'Test Message',
                            processedMessage: 'Processed Message',
                            boolean: true,
                            date: '2024-01-01',
                            createdAt: '2024-01-01',
                            character: {
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
                        },
                    ],
                },
            };
            return mockResponse;
        }
        post(url: string, params: any, body: any): Promise<Output> {
            throw new Error('Method not implemented.');
        }
        delete(url: string, params: any): Promise<Output> {
            throw new Error('Method not implemented.');
        }
        put(url: string, params: any, body: any): Promise<Output> {
            throw new Error('Method not implemented.');
        }

    };

    beforeEach(() => {
        apiReminderGateway = new APIReminderGateway(mockHttpClient);
    });

    it('should list reminders', async () => {

        const reminders = await apiReminderGateway.list(1, 10, 'active');

        expect(reminders.length).toBe(1);
        expect(reminders[0]).toBeInstanceOf(Reminder);
        expect(reminders[0].getId()).toBe('1');
        expect(reminders[0].getOriginalMessage()).toBe('Test Message');
        expect(reminders[0].getCharacter()).toBeInstanceOf(Character);
        expect(reminders[0].getCharacter().getId()).toBe('1');
    });
});
