<?php declare(strict_types=1);

namespace IconLanguageServices\ApiClient\AccessToken;

use DateTimeImmutable;
use GuzzleHttp\Client;
use IconLanguageServices\ApiClient\AccessToken\Error\AccessTokenException;
use IconLanguageServices\ApiClient\AccessToken\Error\InvalidClientCredentials;
use Teapot\StatusCode\Http;

/**
 * Fetches an Access Token from API via HTTP
 */
class Remote implements Repository
{
    private Client $httpClient;
    private string $apiBaseUrl;
    private string $clientId;
    private string $clientSecret;
    private array $scopes;

    public function __construct(Client $httpClient, string $apiBaseUrl, string $clientId, string $clientSecret, array $scopes)
    {
        $this->httpClient = $httpClient;
        $this->apiBaseUrl = $apiBaseUrl;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->scopes = $scopes;
    }

    /**
     * @return AccessToken
     * @throws InvalidClientCredentials Thrown if invalid client credentials are provided
     * @throws AccessTokenException Thrown if iTrans returns any other kind of non-200 OK response
     * @throws \GuzzleHttp\Exception\GuzzleException e.g. ConnectionException in event of failed connection
     */
    public function get(): AccessToken
    {
        $url = rtrim($this->apiBaseUrl, "/") . "/access_token";

        $formParams = $this->getRequestFormParams();
        $headers = $this->getRequestHeaders();
        $requestOptions = $this->getRequestOptions($formParams, $headers);

        $response = $this->httpClient->post($url, $requestOptions);

        $requestBody = (string)$response->getBody();

        if ($response->getStatusCode() === Http::OK) {
            $decoded = json_decode($requestBody, true);
            $expiresAt = DateTimeImmutable::createFromFormat("U", (string)(time() + $decoded["expires_in"]));
            return new AccessToken($expiresAt, $decoded["access_token"]);
        }

        $contentTypeHeader = ($response->getHeader("Content-Type") ?: [0 => null])[0];
        if ($contentTypeHeader === "application/problem+json") {

            $body = json_decode($requestBody, true);

            if ($body["title"] === "invalid_client") {
                throw new InvalidClientCredentials($body["detail"]);
            }

            throw new AccessTokenException("{$body["title"]}:{$body["detail"]}");
        }

        throw new AccessTokenException(
            "Fetching of access token failed with HTTP status {$response->getStatusCode()} {$response->getReasonPhrase()} and body: {$requestBody}"
        );
    }

    private function getRequestOptions(array $formParams, array $headers): array
    {
        return [

            // Guzzle-specific options
            "http_errors" => false, // Guzzle throws by default for any response >= 400

            // HTTP request stuff
            "headers" => $headers,
            "form_params" => $formParams,
        ];
    }

    protected function getRequestFormParams(): array
    {
        return [
            "grant_type" => "client_credentials",
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
            "scopes" => implode(",", $this->scopes),
        ];
    }

    protected function getRequestHeaders(): array
    {
        return [
            "Accept" => "application/json",
            "Content-Type" => "application/x-www-form-urlencoded",
        ];
    }
}
