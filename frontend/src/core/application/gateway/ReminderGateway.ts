import Character from "../../domain/Character";
import Reminder from "../../domain/Reminder";

export default interface ReminderGateway{
    totalRequisited: number;
    list(page: number, limit: number, status: string): Promise<Reminder[]>;
    send(id: string): Promise<Response>;
    delete(id: string): Promise<Response> ;
    create(content: string, character: Character): Promise<Response>;
}

export type ResponseError = {
    type: string,
    errors: String[],
}

export type Response = {
    success: boolean,
    data: any,
    type: string
}