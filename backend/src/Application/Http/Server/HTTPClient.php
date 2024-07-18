<?php

namespace Src\Application\Http\Server;

interface HTTPClient
{
    /**
     * Send a GET request.
     *
     * @param string $url
     * @param array $headers
     * @return array Response data
     * @throws \Exception If request fails
     */
    public function get(string $url, array $headers = []): array;

    /**
     * Send a POST request.
     *
     * @param string $url
     * @param array $headers
     * @param array|string|null $body
     * @return array Response data
     * @throws \Exception If request fails
     */
    public function post(string $url, array $headers = [], $body = null): array;

    /**
     * Send a PUT request.
     *
     * @param string $url
     * @param array $headers
     * @param array|string|null $body
     * @return array Response data
     * @throws \Exception If request fails
     */
    public function put(string $url, array $headers = [], $body = null): array;

    /**
     * Send a DELETE request.
     *
     * @param string $url
     * @param array $headers
     * @return array Response data
     * @throws \Exception If request fails
     */
    public function delete(string $url, array $headers = []): array;
}
?>
