<?php

namespace Dreamcasa\LeadEasyTest\AppProvider;

/**
 * Tell the application the way that you'd like to receive the payload
 */
enum ProviderPayloadContentType: string
{
    /**
     * Example JSON:
     *  {"reference":"AP1234","name":"Person Name","email":"email@example.com","phone":"551199999999","message":"Message is here"}
     */
    case JSON = 'application/json';

    /**
     * Example form encoded:
     *  reference=AP1234&name=Person+Name&email=email%40example.com&phone=551199999999&message=Message+is+here
     */
    case FORM = 'application/x-www-form-urlencoded';
}
