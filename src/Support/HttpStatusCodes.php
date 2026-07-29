<?php

namespace Saimain\LaravelMockApi\Support;

class HttpStatusCodes
{
    /**
     * @return array<string, array<int, array{0: string, 1: string}>>
     */
    public static function grouped(): array
    {
        return [
            'Informational' => [
                100 => ['Continue', 'The server has received the request headers and the client should proceed to send the request body.'],
                101 => ['Switching Protocols', 'The requester has asked the server to switch protocols.'],
                102 => ['Processing', 'The server has received and is processing the request, but no response is available yet.'],
                103 => ['Early Hints', 'Used to return some response headers before the final HTTP message.'],
            ],
            'Success' => [
                200 => ['OK', 'The request succeeded.'],
                201 => ['Created', 'The request succeeded and a new resource was created as a result.'],
                202 => ['Accepted', 'The request has been received but not yet acted upon.'],
                203 => ['Non-Authoritative Information', 'The returned metadata is not exactly the same as available from the origin server.'],
                204 => ['No Content', 'There is no content to send, but the headers are useful.'],
                205 => ['Reset Content', 'Tells the client to reset the document that sent this request.'],
                206 => ['Partial Content', 'Used with range requests to deliver only part of a resource.'],
                207 => ['Multi-Status', 'Conveys information about multiple resources (WebDAV).'],
                208 => ['Already Reported', 'The members of a DAV binding have already been enumerated in a previous reply (WebDAV).'],
                226 => ['IM Used', 'The server has fulfilled a request for the resource using instance manipulations.'],
            ],
            'Redirection' => [
                300 => ['Multiple Choices', 'The request has more than one possible response.'],
                301 => ['Moved Permanently', 'The resource has been permanently moved to a new URL.'],
                302 => ['Found', 'The resource resides temporarily under a different URL.'],
                303 => ['See Other', 'The response can be found under a different URL using a GET request.'],
                304 => ['Not Modified', 'The resource has not been modified since the last request.'],
                307 => ['Temporary Redirect', 'The resource is temporarily under a different URL; the method must not change.'],
                308 => ['Permanent Redirect', 'The resource has permanently moved to a new URL; the method must not change.'],
            ],
            'Client Error' => [
                400 => ['Bad Request', 'The server cannot process the request due to a client error.'],
                401 => ['Unauthorized', 'Authentication is required and has failed or has not been provided.'],
                402 => ['Payment Required', 'Reserved for future use.'],
                403 => ['Forbidden', 'The client does not have access rights to the content.'],
                404 => ['Not Found', 'The server cannot find the requested resource.'],
                405 => ['Method Not Allowed', 'The request method is not supported for this resource.'],
                406 => ['Not Acceptable', 'No content matching the request\'s Accept headers was found.'],
                407 => ['Proxy Authentication Required', 'Authentication with the proxy is required.'],
                408 => ['Request Timeout', 'The server timed out waiting for the request.'],
                409 => ['Conflict', 'The request conflicts with the current state of the resource.'],
                410 => ['Gone', 'The resource is no longer available and will not be available again.'],
                411 => ['Length Required', 'The Content-Length header is required.'],
                412 => ['Precondition Failed', 'A precondition in the request headers evaluated to false.'],
                413 => ['Content Too Large', 'The request body is larger than the server is willing to process.'],
                414 => ['URI Too Long', 'The requested URI is longer than the server is willing to interpret.'],
                415 => ['Unsupported Media Type', 'The media format of the request is not supported.'],
                416 => ['Range Not Satisfiable', 'The requested range cannot be fulfilled.'],
                417 => ['Expectation Failed', 'The expectation in the request\'s Expect header could not be met.'],
                418 => ["I'm a Teapot", 'The server refuses to brew coffee because it is, permanently, a teapot.'],
                421 => ['Misdirected Request', 'The request was directed at a server that cannot produce a response.'],
                422 => ['Unprocessable Content', 'The request was well-formed but semantically invalid.'],
                423 => ['Locked', 'The resource being accessed is locked (WebDAV).'],
                424 => ['Failed Dependency', 'The request failed due to a failure of a previous request (WebDAV).'],
                425 => ['Too Early', 'The server is unwilling to risk processing a request that might be replayed.'],
                426 => ['Upgrade Required', 'The client should switch to a different protocol.'],
                428 => ['Precondition Required', 'The origin server requires the request to be conditional.'],
                429 => ['Too Many Requests', 'The user has sent too many requests in a given amount of time.'],
                431 => ['Request Header Fields Too Large', 'The request\'s header fields are too large.'],
                451 => ['Unavailable For Legal Reasons', 'The resource is unavailable for legal reasons.'],
            ],
            'Server Error' => [
                500 => ['Internal Server Error', 'The server encountered an unexpected condition.'],
                501 => ['Not Implemented', 'The request method is not supported by the server.'],
                502 => ['Bad Gateway', 'The server received an invalid response from an upstream server.'],
                503 => ['Service Unavailable', 'The server is not ready to handle the request.'],
                504 => ['Gateway Timeout', 'The upstream server failed to send a request in time.'],
                505 => ['HTTP Version Not Supported', 'The HTTP version used in the request is not supported.'],
                506 => ['Variant Also Negotiates', 'The server has an internal configuration error.'],
                507 => ['Insufficient Storage', 'The server is unable to store the representation needed to complete the request (WebDAV).'],
                508 => ['Loop Detected', 'The server detected an infinite loop while processing the request (WebDAV).'],
                510 => ['Not Extended', 'Further extensions to the request are required for the server to fulfill it.'],
                511 => ['Network Authentication Required', 'The client needs to authenticate to gain network access.'],
            ],
        ];
    }

    public static function isKnown(int $code): bool
    {
        foreach (self::grouped() as $codes) {
            if (array_key_exists($code, $codes)) {
                return true;
            }
        }

        return false;
    }

    public static function phrase(int $code): ?string
    {
        foreach (self::grouped() as $codes) {
            if (array_key_exists($code, $codes)) {
                return $codes[$code][0];
            }
        }

        return null;
    }
}
