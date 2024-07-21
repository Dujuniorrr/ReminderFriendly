import ReminderGateway from "../gateway/ReminderGateway";
/**
 * @export
 * @class CreateReminder
 */
export default class CreateReminder {
    constructor(
        private readonly reminderGteway: ReminderGateway
    ) { }

    /**
     *
     *
     * @param {string} id
     * @return {*}  {Promise<Output>}
     * @memberof CreateReminder
     */
    public async execute(input: Input): Promise<Output> {
        const response = await this.reminderGteway.create(input.content, input.characterId);

        switch (response.type) {
            case 'success':
                return {
                    success: true,
                    content_error: false,
                    message: 'Lembrete adicionado!'
                }
            case 'content_error':
                return {
                    success: false,
                    content_error: true,
                    message: response.data.content_error
                }
            default:
                return {
                    success: false,
                    content_error: false,
                    message: 'Eita! Algum erro ocorreu...'
                }
        }

    }
}

type Input = {
    content: string,
    characterId: string
}

export type Output = {
    success: boolean,
    content_error: boolean,
    message: string
}