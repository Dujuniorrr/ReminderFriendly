import Reminder from "../../domain/Reminder";

/**
 * @export
 * @interface ReminderGateway
 */
export default interface ReminderGateway {

    /**
     * @type {number}
     * @memberof ReminderGateway
     */
    totalRequisited: number;

    /**
     * @param {number} page
     * @param {number} limit
     * @param {string} status
     * @return {*}  {Promise<Reminder[]>}
     * @memberof ReminderGateway
     */

    list(page: number, limit: number, status: string): Promise<Reminder[]>;

    /**
   * @param {number} month
   * @param {number} year
   * @return {*}  {Promise<Reminder[]>}
   * @memberof ReminderGateway
   */

    listByMonth(month: number, year: number): Promise<Reminder[]>;

    /**
     * @param {string} id
     * @return {*}  {Promise<Response>}
     * @memberof ReminderGateway
     */

    send(id: string): Promise<Response>;

    /**
     * @param {string} id
     * @return {*}  {Promise<Response>}
     * @memberof ReminderGateway
     */
    delete(id: string): Promise<Response>;


    /**
     * @param {string} content
     * @param {string} characterId
     * @return {*}  {Promise<Response>}
     * @memberof ReminderGateway
     */
    create(content: string, characterId: string): Promise<Response>;
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