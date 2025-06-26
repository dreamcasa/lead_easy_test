<?php

namespace Dreamcasa\LeadEasyTest;

use InvalidArgumentException;

class User
{
    /**
     * This is created in the Authentication Process.
     * @var string
     */
    private string $token;

    public function __construct()
    {
        $this->token = getenv('USER_UNIQ_TOKEN');
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        if ($this->token === '') {
            $message = 'The USER_UNIQ_TOKEN must to be created in the .env file.';
            throw new InvalidArgumentException($message);
        }
        return $this->token;
    }
}
