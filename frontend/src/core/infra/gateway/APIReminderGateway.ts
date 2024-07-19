import ReminderGateway, { ResponseError } from "../../application/gateway/ReminderGateway";
import HttpClient from "../../application/http/HttpClient";
import Character from "../../domain/Character";
import Reminder from "../../domain/Reminder";


export default class APIReminderGateway implements ReminderGateway {
    private endpoint: string = 'reminder';;
    private apiUrl: string = 'http://localhost:9000/api/';
    totalRequisited: number = 0;

    constructor(
        private readonly httpClient: HttpClient
    ) {
    }

    async list(page: number, limit: number, status: string): Promise<Reminder[]> {
        const response = await this.httpClient.get(`${this.apiUrl}${this.endpoint}`, {
            page, limit, status
        });
       
         this.totalRequisited = response.data.total ?? 0;
         
        let reminders: Reminder[] = [];
        if (response.success) {
            reminders = response.data.reminders.map((reminder: any) => {
                return new Reminder(
                    reminder.id,
                    reminder.originalMessage,
                    reminder.processedMessage,
                    reminder.boolean,
                    reminder.date,
                    reminder.createdAt,
                    new Character(
                        reminder.character.id,
                        reminder.character.name,
                        reminder.character.humor,
                        reminder.character.role,
                        reminder.character.ageVitality,
                        reminder.character.origin,
                        reminder.character.speechMannerisms,
                        reminder.character.accent,
                        reminder.character.archetype,
                        reminder.character.imagePath,
                        reminder.character.color,

                    )
                )
            });
        }
        return reminders;
    }

    async delete(id: string): Promise<boolean> {
        throw new Error("Method not implemented.");
    }

    async create(content: string, character: Character): Promise<boolean | ResponseError> {
        throw new Error("Method not implemented.");
    }

}