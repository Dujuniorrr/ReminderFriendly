import SendReminder, { Output } from "../../../../core/application/command/SendReminder";
import ReminderGateway from "../../../../core/application/gateway/ReminderGateway";
import HttpClient from "../../../../core/application/http/HttpClient";
import APIReminderGateway from "../../../../core/infra/gateway/APIReminderGateway";
import AxiosHttpClient from "../../../../core/infra/http/AxiosHttpClient";

describe('SendReminder', () => {
    let httpClient: HttpClient;
    let reminderGateway: ReminderGateway;
    let sendReminder: SendReminder;

    beforeEach(() => {
        httpClient = new AxiosHttpClient();
        reminderGateway = new APIReminderGateway(httpClient);
        sendReminder = new SendReminder(reminderGateway);
    });

    test('should successfully send a reminder', async () => {
        const output: Output = await sendReminder.execute('7');

        expect(output.success).toBe(true);
        expect(output.message).toBe('Lembrete enviado');
    });

    test('should return already sent when reminder has already been sent', async () => {
        jest.spyOn(reminderGateway, 'send').mockResolvedValue({
            success: false,
            type: 'already_send',
            data: {}
        });

        const output: Output = await sendReminder.execute('1');

        expect(output.success).toBe(false);
        expect(output.message).toBe('Opsss! Parece que esse lembrete já foi enviado.');
    });

    test('should return not found when reminder is not found', async () => {
        jest.spyOn(reminderGateway, 'send').mockResolvedValue({
            success: false,
            type: 'not_found',
            data: {}
        });

        const output: Output = await sendReminder.execute('non-existent-id');

        expect(output.success).toBe(false);
        expect(output.message).toBe('Eita, onde está? Esse lembrete não foi encontado.');
    });

    test('should handle errors when sending a reminder', async () => {
        jest.spyOn(reminderGateway, 'send').mockResolvedValue({
            success: false,
            type: 'error',
            data: {}
        });

        const output: Output = await sendReminder.execute('1');

        expect(output.success).toBe(false);
        expect(output.message).toBe('Eita! Algum erro ocorreu...');
    });
});
