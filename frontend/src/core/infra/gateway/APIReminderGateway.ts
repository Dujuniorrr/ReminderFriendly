import ReminderGateway, { Response, ResponseError } from "../../application/gateway/ReminderGateway";
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
                    reminder.send,
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

    async delete(id: string): Promise<Response> {
        const response = await this.httpClient.delete(`${this.apiUrl}${this.endpoint}/${id}`, {});

        if (response.success) return {
            success: true,
            data: response.data,
            type: 'success'
        };

        return {
            type: (response.status == 404) ? 'not_found' : 'error',
            data: response.data,
            success: false
        }
    }

    async send(id: string): Promise<Response> {
        const response = await this.httpClient.put(`${this.apiUrl}${this.endpoint}/${id}/send`, {}, {});

        if (response.success) return {
            success: true,
            data: response.data,
            type: 'success'
        };

        return {
            success: false,
            type: (response.status == 404) ? 'not_found' : 'already_send',
            data: response.data
        }
    }


    async create(content: string, characterId: string): Promise<Response> {
        const response = await this.httpClient.post(`${this.apiUrl}${this.endpoint}
        `, {}, {
            content,
            characterId
        });

        if (response.success) return {
            success: true,
            data: response.data,
            type: 'success'
        };
 
        return {
            success: false,
            type: (response.data?.content_error) ? 'content_error' : 'error',
            data: response.data
        }
    }

}