Senior Software Engineer (PHP)

Technical test
==============


We have developed an API, protected by OAuth2. We have a number of client applications that will need to
make requests to the API; each client application will therefore need to be able to obtain a valid access token.

We have developed this library to provide an abstraction of how to get an access token from the API. Access tokens
are valid for one hour. Client applications should not need to request a new access token for every single API request; it should be possible to persist the access token so that it can be shared between API requests across different browser sessions.

Task: extend this library, providing a new Repository implementation which allows for token re-use.

- The library must be able to retrieve a token from a storage implementation and determine if it is still valid.
- The library must be able to make an API request for a new token if the token is not still valid.
- If the library obtains a new token from the API, it must be able to save it in storage.
- The library must be agnostic with regard to the storage implementation used by the client code.


Deliverables
============

Please clone this repository, commit your solution to a public github repository, and send us a link to the repository.
You may use any composer dependencies you wish.

