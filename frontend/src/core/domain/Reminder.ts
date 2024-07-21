import Character from "./Character";

export default class Reminder {
    constructor(
        private readonly id: string,
        private readonly originalMessage: string,
        private readonly processedMessage: string,
        private readonly send: boolean,
        private readonly date: Date,
        private readonly createdAt: Date,
        private readonly character: Character,
    ) {

    }

    public getId(): string {
        return this.id;
    }

    public getOriginalMessage(): string {
        return this.originalMessage;
    }

    public getProcessedMessage(): string {
        return this.processedMessage;
    }

    public getSend(): boolean {
        return this.send;
    }

    public getDate(): Date {
        return this.date;
    }

    public getCreatedAt(): Date {
        return this.createdAt;
    }

    public getCharacter(): Character {
        return this.character;
    }

}