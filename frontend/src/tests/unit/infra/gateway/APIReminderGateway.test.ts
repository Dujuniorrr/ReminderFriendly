import HttpClient, { Output } from '../../../../core/application/http/HttpClient';
import Character from '../../../../core/domain/Character';
import Reminder from '../../../../core/domain/Reminder';
import APIReminderGateway from '../../../../core/infra/gateway/APIReminderGateway';

describe('APIReminderGateway', () => {
    let apiReminderGateway: APIReminderGateway;
    let mockHttpClient: HttpClient = new class Mock implements HttpClient {
        async get(url: string, params: any): Promise<Output> {
            if (url.includes('error')) {
                return {
                    success: false,
                    status: 500,
                    data: {}
                };
            }
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
        async post(url: string, params: any, body: any): Promise<Output> {
            throw new Error('Method not implemented.');
        }
        async delete(url: string, params: any): Promise<Output> {
            if (url.includes('error')) {
                return {
                    success: false,
                    status: 404,
                    data: {}
                };
            }
            const mockResponse = {
                success: true,
                status: 200,
                data: {},
            };
            return mockResponse;
        }
        async put(url: string, params: any, body: any): Promise<Output> {
            if (url.includes('error')) {
                return {
                    success: false,
                    status: 500,
                    data: {}
                };
            }
            const mockResponse = {
                success: true,
                status: 200,
                data: {},
            };
            return mockResponse;
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

    it('should handle error when listing reminders', async () => {
        mockHttpClient.get = async (url: string, params: any): Promise<Output> => ({
            success: false,
            status: 500,
            data: {}
        });

        const reminders = await apiReminderGateway.list(1, 10, 'active');

        expect(reminders.length).toBe(0);
    });

    it('should delete a reminder', async () => {
        const response = await apiReminderGateway.delete('1');

        expect(response.success).toBe(true);
        expect(response.type).toBe('success');
    });

    it('should handle error when deleting a reminder', async () => {
        const response = await apiReminderGateway.delete('error');

        expect(response.success).toBe(false);
        expect(response.type).toBe('not_found');
    });

    it('should send a reminder', async () => {
        const response = await apiReminderGateway.send('1');

        expect(response.success).toBe(true);
        expect(response.type).toBe('success');
    });

    it('should handle error when sending a reminder', async () => {
        const response = await apiReminderGateway.send('error');

        expect(response.success).toBe(false);
        expect(response.type).toBe('already_send');
    });

    it('should create a reminder', async () => {
        const response = await apiReminderGateway.create('New Reminder', '1');

        expect(response.success).toBe(true);
        expect(response.type).toBe('success');
    });

    it('should handle error when creating a reminder', async () => {
        mockHttpClient.put = async (url: string, params: any, body: any): Promise<Output> => ({
            success: false,
            status: 400,
            data: { content_error: true }
        });

        const response = await apiReminderGateway.create('Error Reminder', '1');

        expect(response.success).toBe(false);
        expect(response.type).toBe('content_error');
    });
});
