import DeleteReminder from "../../../../core/application/command/DeleteReminder";
import ReminderGateway from "../../../../core/application/gateway/ReminderGateway";
import HttpClient, { Output as HttpOutput } from "../../../../core/application/http/HttpClient";
import APIReminderGateway from "../../../../core/infra/gateway/APIReminderGateway";
import AxiosHttpClient from "../../../../core/infra/http/AxiosHttpClient";

test('should successfully delete a reminder', async () => {
    const httpClient: HttpClient = new AxiosHttpClient();
    const reminderGateway: ReminderGateway = new APIReminderGateway(httpClient);
    const deleteReminder = new DeleteReminder(reminderGateway);

    const output = await deleteReminder.execute('3');

    expect(output.success).toBe(true);
    expect(output.message).toBe('Lembrete deletado!');
});

test('should return not found when deleting a non-existent reminder', async () => {
    const httpClient: HttpClient = new AxiosHttpClient();
    const reminderGateway: ReminderGateway = new APIReminderGateway(httpClient);
    const deleteReminder = new DeleteReminder(reminderGateway);

    const output = await deleteReminder.execute('non-existent-id');

    expect(output.success).toBe(false);
    expect(output.message).toBe('Eita, onde está? Esse lembrete não foi encontado.');
});

test('should handle errors when deleting a reminder', async () => {
    const mockHttpClient: HttpClient = {
        async get(url: string, params: any): Promise<HttpOutput> {
            throw new Error('Method not implemented.');
        },
        async post(url: string, params: any, body: any): Promise<HttpOutput> {
            throw new Error('Method not implemented.');
        },
        async delete(url: string, params: any): Promise<HttpOutput> {
            return {
                success: false,
                status: 500,
                data: {}
            };
        },
        async put(url: string, params: any, body: any): Promise<HttpOutput> {
            throw new Error('Method not implemented.');
        }
    };

    const reminderGateway: ReminderGateway = new APIReminderGateway(mockHttpClient);
    const deleteReminder = new DeleteReminder(reminderGateway);

    const output = await deleteReminder.execute('1');

    expect(output.success).toBe(false);
    expect(output.message).toBe('Eita! Algum erro ocorreu...');
});
