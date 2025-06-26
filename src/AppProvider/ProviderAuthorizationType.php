<?php

namespace Dreamcasa\LeadEasyTest\AppProvider;

/**
 *  The way that the user token inputted in the Authorization process will be delivered.
 */
enum ProviderAuthorizationType
{
    /**
     *  In the request header like:
     * Authorization: Bearer SomeHashHere
     */
    case HEADER;

    /**
     * In the payload like:
     *{"token":"your_token", ...}
     */
    case PAYLOAD;
}
