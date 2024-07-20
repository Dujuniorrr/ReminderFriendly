import axios, { AxiosError, AxiosResponse } from "axios";
import HttpClient, { Output } from "../../application/http/HttpClient";

export default class AxiosHttpClient implements HttpClient {
    
    async delete(url: string, params: any): Promise<Output> {
        try {
            const response = await axios.delete(url, { params });
            return this.formatResponse(response);
        }
        catch (error: any) {
            return this.formatResponseError(error)
        }
    }

    async put(url: string, params: any, body: any): Promise<Output> {

        try {
            const response = await axios.put(url, body, { params });
            return this.formatResponse(response);
        }
        catch (error: any) {
            return this.formatResponseError(error)
        }

    }

    async get(url: string, params: any): Promise<Output> {
        try {
            const response = await axios.get(url, { params });
            return this.formatResponse(response);
        }
        catch (error: any) {
            return this.formatResponseError(error)
        }

    }

    async post(url: string, params: any, body: any): Promise<Output> {
        try {
            const response = await axios.post(url, body, { params });
            return this.formatResponse(response);
        }
        catch (error: any) {
            return this.formatResponseError(error)
        }
    }

    private formatResponse(response: AxiosResponse<any, any>): Output {
        return {
            data: response.data,
            status: response.status,
            success: response.status >= 200 && response.status <= 299
        };
    }

    private formatResponseError(error: AxiosError): Output {
        if(error.response){
            return this.formatResponse(error.response);
        }
        return {
            data: [],
            status: null,
            success: false
        };
    }
}
