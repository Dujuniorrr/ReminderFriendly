import ListReminders from "../../../../core/application/command/ListReminders";
import ReminderGateway from "../../../../core/application/gateway/ReminderGateway";
import HttpClient from "../../../../core/application/http/HttpClient";
import APIReminderGateway from "../../../../core/infra/gateway/APIReminderGateway";
import AxiosHttpClient from "../../../../core/infra/http/AxiosHttpClient";

test('must return a list of reminders', async () => {
    const httpClient: HttpClient = new AxiosHttpClient();
    const reminderGteway: ReminderGateway = new APIReminderGateway(httpClient);
    const listReminders = new ListReminders(reminderGteway);

    const output = await listReminders.execute({
        page: 1,
        limit: 20,
        status: 'notSend'
    });

    expect(output.length).toBeLessThan(20);
});
