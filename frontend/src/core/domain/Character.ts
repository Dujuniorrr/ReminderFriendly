export default class Character {
    constructor(
        private readonly id: string,
        private readonly name: string,
        private readonly humor: string,
        private readonly role: string,
        private readonly ageVitality: string,
        private readonly origin: string,
        private readonly speechMannerisms: string,
        private readonly accent: string,
        private readonly archetype: string,
        private readonly imagePath: string,
        private readonly color: string,

    ) {

    }

    public getId(): string {
        return this.id;
    }

    public getName(): string {
        return this.name;
    }

    public getHumor(): string {
        return this.humor;
    }

    public getRole(): string {
        return this.role;
    }

    public getAgeVitality(): string {
        return this.ageVitality;
    }

    public getOrigin(): string {
        return this.origin;
    }

    public getSpeechMannerisms(): string {
        return this.speechMannerisms;
    }

    public getAccent(): string {
        return this.accent;
    }

    public getArchetype(): string {
        return this.archetype;
    }

    public getImagePath(): string {
        return this.imagePath;
    }

    public getColor(): string {
        return this.color;
    }


}