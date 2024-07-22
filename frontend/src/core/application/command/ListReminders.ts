import Reminder from "../../domain/Reminder";
import ReminderGateway from "../gateway/ReminderGateway";
import DatePresenter from "../presenter/DatePresenter";
/**
 * @export
 * @class ListReminders
 */
export default class ListReminders {
    /**
     * Creates an instance of ListReminders.
     * @param {ReminderGateway} reminderGateway
     * @memberof ListReminders
     */
    constructor(
        private readonly reminderGateway: ReminderGateway
    ) { }

    /**
     * @param {Input} input
     * @return {*}  {Promise<Output[]>}
     * @memberof ListReminders
     */
    public async execute(input: Input): Promise<Output[]> {
        const reminders: Reminder[] = await this.reminderGateway.list(input.page, input.limit, input.status, input.search);
        const output: Output[] = reminders.map((reminder: Reminder) => {
            return {
                id: reminder.getId(),
                originalMessage: reminder.getOriginalMessage(),
                processedMessage: reminder.getProcessedMessage(),
                date: DatePresenter.present(reminder.getDate().toString()),
                send: reminder.getSend(),
                character: {
                    id: reminder.getCharacter().getId(),
                    name: reminder.getCharacter().getName(),
                    imagePath: reminder.getCharacter().getImagePath(),
                    color: reminder.getCharacter().getColor()
                }
            }
        })
        return output;
    }
}

type Input = {
    page: number,
    limit: number,
    status: string,
    search: string|null,
}

export type Output = {
    id: string,
    originalMessage: string,
    processedMessage: string,
    date: string,
    send: boolean,
    character: {
        id: string,
        name: string,
        imagePath: string,
        color: string
    }
}