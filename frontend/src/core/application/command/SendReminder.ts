import ReminderGateway from "../gateway/ReminderGateway";

export default class SendReminder {
    constructor(
        private readonly reminderGteway: ReminderGateway
    ) { }

    /**
     * @param {string} id
     * @return {*}  {Promise<Output>}
     * @memberof SendReminder
     */
    public async execute(id: string): Promise<Output> {
        const response = await this.reminderGteway.send(id);
        switch (response.type) {
            case 'success':
                return {
                    success: true,
                    message: 'Lembrete enviado'
                }
            case 'already_send':
                return {
                    success: false,
                    message: 'Opsss! Parece que esse lembrete já foi enviado.'
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

export type Output = {
    success: boolean,
    message: string
}