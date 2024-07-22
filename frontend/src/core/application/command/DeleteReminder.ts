import ReminderGateway from "../gateway/ReminderGateway";
/**
 * @export
 * @class DeleteReminder
 */
export default class DeleteReminder {
    constructor(
        private readonly reminderGateway: ReminderGateway
    ) { }
    
    /**
     *
     *
     * @param {string} id
     * @return {*}  {Promise<Output>}
     * @memberof DeleteReminder
     */
    public async execute(id: string): Promise<Output> {
        const response = await this.reminderGateway.delete(id);

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