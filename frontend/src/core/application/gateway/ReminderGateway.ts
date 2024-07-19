import Character from "../../domain/Character";
import Reminder from "../../domain/Reminder";

export default interface ReminderGateway{
    totalRequisited: number;
    list(page: number, limit: number, status: string): Promise<Reminder[]>;
    delete(id: string): Promise<boolean>;
    create(content: string, character: Character): Promise<ResponseError|boolean>;
}

export type ResponseError = {
    type: string,
    errors: String[]
}