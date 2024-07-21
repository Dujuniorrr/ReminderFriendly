import Character from "../../domain/Character";

/**
 * @export
 * @interface CharacterGateway
 */
export default interface CharacterGateway {
    /**
     * @return {*}  {Promise<Character[]>}
     * @memberof CharacterGateway
     */
    list(): Promise<Character[]>;
}
