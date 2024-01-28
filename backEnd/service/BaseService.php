<?php

/**
 * Base service class. All application's service must extends this class.
 */
abstract class BaseService {

    /**
     * Exit the program with HTTP 500 code and return the $errorMessage. The $httpResponseCode can be overriden.
     */
    protected function fatalError(string $errorMessage, int $httpResponseCode = 500): void {
        http_response_code($httpResponseCode);
        exit($message);
    }
}
