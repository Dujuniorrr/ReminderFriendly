import CreateReminder from "../../../../core/application/command/CreateReminder";
import ReminderGateway from "../../../../core/application/gateway/ReminderGateway";
import APIReminderGateway from "../../../../core/infra/gateway/APIReminderGateway";
import AxiosHttpClient from "../../../../core/infra/http/AxiosHttpClient";


describe('CreateReminder Integration Test', () => {
    let createReminder: CreateReminder;
    let reminderGateway: ReminderGateway;

    beforeAll(() => {
        const httpClient = new AxiosHttpClient();
        reminderGateway = new APIReminderGateway(httpClient);
        createReminder = new CreateReminder(reminderGateway);
    });

    it('should successfully create a reminder', async () => {
        const input = { content: 'Ir ao parque amanhã as 7 e meia da manhâ', characterId: '1' };

        const output = await createReminder.execute(input);

        expect(output).toEqual({
            success: true,
            content_error: false,
            message: 'Lembrete adicionado!'
        });
    });

    it('should return content_error when content_error occurs because no date', async () => {
        const input = { content: 'Ir ao parque amanhã', characterId: '1' };

        const output = await createReminder.execute(input);

        expect(output.content_error).toEqual(true);
    });


    it('should return content_error when content_error occurs because no task', async () => {
        const input = { content: 'as 7 e meia', characterId: '1' };

        const output = await createReminder.execute(input);

        expect(output.content_error).toEqual(true);
    });

    it('should return default error message when an unknown error occurs', async () => {
        const input = { content: 'Test Reminder', characterId: '999' };

        const output = await createReminder.execute(input);

        expect(output).toEqual({
            success: false,
            content_error: false,
            message: 'Eita! Algum erro ocorreu...'
        });
    });
});
