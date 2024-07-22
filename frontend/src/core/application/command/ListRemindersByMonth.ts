import Reminder from "../../domain/Reminder";
import ReminderGateway from "../gateway/ReminderGateway";
import DatePresenter from "../presenter/DatePresenter";
/**
 * @export
 * @class ListRemindersByMonth
 */
export default class ListRemindersByMonth {
    /**
     * Creates an instance of ListRemindersByMonth.
     * @param {ReminderGateway} reminderGateway
     * @memberof ListRemindersByMonth
     */
    constructor(
        private readonly reminderGateway: ReminderGateway
    ) { }

    /**
     * @param {Input} input
     * @return {*}  {Promise<Output[]>}
     * @memberof ListRemindersByMonth
     */
    public async execute(input: Input): Promise<Output[]> {
        const reminders: Reminder[] = await this.reminderGateway.listByMonth(input.month, input.year);
        const output: Output[] = reminders.map((reminder: Reminder) => {
            return {
                id: reminder.getId(),
                originalMessage: reminder.getOriginalMessage(),
                processedMessage: reminder.getProcessedMessage(),
                date: reminder.getDate().toString(),
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
    year: number,
    month: number,
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