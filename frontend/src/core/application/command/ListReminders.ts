import Reminder from "../../domain/Reminder";
import ReminderGateway from "../gateway/ReminderGateway";
import DatePresenter from "../presenter/DatePresenter";

export default class ListReminders {
    constructor(
        private readonly reminderGteway: ReminderGateway
    ) { }

    public async execute(input: Input): Promise<Output[]> {
        const reminders: Reminder[] = await this.reminderGteway.list(input.page, input.limit, input.status);
        const output: Output[] = reminders.map((reminder: Reminder) => {
            return {
                id: reminder.getId(),
                originalMessage: reminder.getOriginalMessage(),
                processedMessage: reminder.getProcessedMessage(),
                date: DatePresenter.present(reminder.getDate().toString()),
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
    status: string
}

export type Output = {
    id: string,
    originalMessage: string,
    processedMessage: string,
    date: string,
    character: {
        id: string,
        name: string,
        imagePath: string,
        color: string
    }
}