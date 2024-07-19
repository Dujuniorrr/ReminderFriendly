export default interface HttpClient {
	get(url: string, params: any): Promise<Output>;
	post(url: string, params: any, body: any): Promise<Output>;
	delete(url: string, params: any): Promise<Output>;
	put(url: string, params: any, body: any): Promise<Output>;
}

export type Output = {
	status: number|null,
	data: any,
	success: boolean
}

