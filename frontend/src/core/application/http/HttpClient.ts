/**
 * @export
 * @interface HttpClient
 */
export default interface HttpClient {
	
	/**
	 * @param {string} url
	 * @param {*} params
	 * @return {*}  {Promise<Output>}
	 * @memberof HttpClient
	 */
	get(url: string, params: any): Promise<Output>;
	
	/**
	 * @param {string} url
	 * @param {*} params
	 * @param {*} body
	 * @return {*}  {Promise<Output>}
	 * @memberof HttpClient
	 */
	post(url: string, params: any, body: any): Promise<Output>;
	
	/**
	 * @param {string} url
	 * @param {*} params
	 * @return {*}  {Promise<Output>}
	 * @memberof HttpClient
	 */
	delete(url: string, params: any): Promise<Output>;
	
	/**
	 * @param {string} url
	 * @param {*} params
	 * @param {*} body
	 * @return {*}  {Promise<Output>}
	 * @memberof HttpClient
	 */
	put(url: string, params: any, body: any): Promise<Output>;
}

export type Output = {
	status: number | null,
	data: any,
	success: boolean
}

