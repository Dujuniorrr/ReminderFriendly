import AxiosHttpClient from "../../../../core/infra/http/AxiosHttpClient";
import HttpClient from "../../../../core/application/http/HttpClient";
import axios from "axios";

jest.mock("axios");
const mockedAxios = axios as jest.Mocked<typeof axios>;

describe('AxiosHttpClient', () => {
    let httpClient: AxiosHttpClient;

    beforeEach(() => {
        httpClient = new AxiosHttpClient();
    });

    it('should return formatted response for GET requests', async () => {
        const mockResponse: any = {
            data: { key: 'value' },
            status: 200,
            statusText: 'OK',
            headers: {},
            config: {},
        };

        mockedAxios.get.mockResolvedValue(mockResponse);

        const response = await httpClient.get('http://example.com', { param: 'value' });

        expect(response).toEqual({
            data: mockResponse.data,
            status: mockResponse.status,
            success: true,
        });
    });

    it('should return formatted response for POST requests', async () => {
        const mockResponse: any = {
            data: { key: 'value' },
            status: 201,
            statusText: 'Created',
            headers: {},
            config: {},
        };

        mockedAxios.post.mockResolvedValue(mockResponse);

        const response = await httpClient.post('http://example.com', { param: 'value' }, { body: 'data' });

        expect(response).toEqual({
            data: mockResponse.data,
            status: mockResponse.status,
            success: true,
        });
    });

    it('should return formatted response for PUT requests', async () => {
        const mockResponse: any = {
            data: { key: 'updated value' },
            status: 200,
            statusText: 'OK',
            headers: {},
            config: {},
        };

        mockedAxios.put.mockResolvedValue(mockResponse);

        const response = await httpClient.put('http://example.com', { param: 'value' }, { body: 'updated data' });

        expect(response).toEqual({
            data: mockResponse.data,
            status: mockResponse.status,
            success: true,
        });
    });

    it('should return formatted response for DELETE requests', async () => {
        const mockResponse: any = {
            data: { success: true },
            status: 204,
            statusText: 'No Content',
            headers: {},
            config: {},
        };

        mockedAxios.delete.mockResolvedValue(mockResponse);

        const response = await httpClient.delete('http://example.com', { param: 'value' });

        expect(response).toEqual({
            data: mockResponse.data,
            status: mockResponse.status,
            success: true,
        });
    });

    it('should handle unsuccessful GET requests', async () => {
        const mockResponse: any = {
            data: { error: 'not found' },
            status: 404,
            statusText: 'Not Found',
            headers: {},
            config: {},
        };

        mockedAxios.get.mockResolvedValue(mockResponse);

        const response = await httpClient.get('http://example.com', { param: 'value' });

        expect(response).toEqual({
            data: mockResponse.data,
            status: mockResponse.status,
            success: false,
        });
    });

    it('should handle errors in GET requests', async () => {
        mockedAxios.get.mockRejectedValue(new Error('Network error'));

        expect(await httpClient.get('http://example.com', { param: 'value' })).toEqual({
            data: [],
            status: null,
            success: false,
        });
    });

    it('should handle errors in POST requests', async () => {
        mockedAxios.post.mockRejectedValue(new Error('Network error'));

        expect(await httpClient.post('http://example.com', { param: 'value' }, { body: 'data' })).toEqual({
            data: [],
            status: null,
            success: false,
        });
    });

    it('should handle errors in PUT requests', async () => {
        mockedAxios.put.mockRejectedValue(new Error('Network error'));

        expect(await httpClient.put('http://example.com', { param: 'value' }, { body: 'updated data' })).toEqual({
            data: [],
            status: null,
            success: false,
        });
    });

    it('should handle errors in DELETE requests', async () => {
        mockedAxios.delete.mockRejectedValue(new Error('Network error'));

        expect(await httpClient.delete('http://example.com', { param: 'value' })).toEqual({
            data: [],
            status: null,
            success: false,
        });
    });

});
