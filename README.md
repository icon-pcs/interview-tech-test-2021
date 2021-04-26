Senior Software Engineer (PHP)

Technical test
==============


We have developed an API, protected by OAuth2. We have a number of client applications that will need to
make requests to the API; each client application will therefore need to be able to obtain a valid access token.

Task: develop an object-oriented, tested, reusable library for obtaining an access token. The code must
be written in PHP (7.4 or 8.0).

Requirements
============

1. The library must be able to obtain an access token from the API.
- The API exposes an endpoint at `/access_token`
- Clients must make a POST request to this endpoint of type `application/x-www-form-urlencoded`
- The following form fields must be present:
    - `grant_type` (string) with value `client_credentials`
    - `client_id` (string) with a parameterizable value
    - `client_secret` (string) with a parameterizable value
    - `scopes` (a comma-separated list of strings) with a parameterizable value
- The API may respond with status 200, 400, or 401, and the client code must be able to handle each response
- In the case of status 200, the API will provide a JSON response object containing the following properties:
    - `token_type` with string value `Bearer`
    - `expires_in` with an int value indicating the number of seconds that the token is valid for
    - `access_token` with a string value containing a base 64-encoded token to be used in future API calls

2. Access tokens are valid for one hour, by default. Therefore, client applications should not need to request a new access token for every single API request; it should be possible to persist the access token so that it can be shared between API requests across different browser sessions.
- The library must be able to retrieve a token from a storage implementation and determine if it is still valid.
- The library must be able to make an API request for a new token if the token is not still valid.
- If the library must be able to store a new valid token from an API request in the storage.  
- The library must be agnostic with regard to the storage implementation used by the client code.

Deliverables
============

Please commit your solution to a public github repository and send us a link to the repository. The repository should include all of your code, tests, and a README with instructions on how to use the library and run the tests. You may use any composer dependencies you wish.

