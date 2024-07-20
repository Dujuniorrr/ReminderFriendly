import ReminderGateway from "../gateway/ReminderGateway";

export default class DeleteReminder {
    constructor(
        private readonly reminderGteway: ReminderGateway
    ) { }

    public async execute(id: string): Promise<Output> {
        const response = await this.reminderGteway.delete(id);

        switch (response.type) {
            case 'success':
                return {
                    success: true,
                    message: 'Lembrete deletado!'
                }
            case 'not_found':
                return {
                    success: false,
                    message: 'Eita, onde está? Esse lembrete não foi encontado.'
                }
            default:
                return {
                    success: false,
                    message: 'Eita! Algum erro ocorreu...'
                }
        }

    }
}

type Output = {
    success: boolean,
    message: string
}