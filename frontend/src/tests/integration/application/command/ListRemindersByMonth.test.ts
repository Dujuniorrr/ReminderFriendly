import ListRemindersByMonth from "../../../../core/application/command/ListRemindersByMonth";
import ReminderGateway from "../../../../core/application/gateway/ReminderGateway";
import HttpClient from "../../../../core/application/http/HttpClient";
import APIReminderGateway from "../../../../core/infra/gateway/APIReminderGateway";
import AxiosHttpClient from "../../../../core/infra/http/AxiosHttpClient";

test('must return a list of reminders', async () => {
    const httpClient: HttpClient = new AxiosHttpClient();
    const reminderGteway: ReminderGateway = new APIReminderGateway(httpClient);
    const listReminders = new ListRemindersByMonth(reminderGteway);

    const output = await listReminders.execute({
        year: 2024,
        month: 8
    });

    expect(output.length).toBeLessThanOrEqual(20);
});



test('must return a list of reminders empty', async () => {
    const httpClient: HttpClient = new AxiosHttpClient();
    const reminderGteway: ReminderGateway = new APIReminderGateway(httpClient);
    const listReminders = new ListRemindersByMonth(reminderGteway);

    const output = await listReminders.execute({
        year: 2012,
        month: 8
    });

    expect(output.length).toBe(0);
});
