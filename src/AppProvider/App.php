<?php

namespace Dreamcasa\LeadEasyTest\AppProvider;

use Dreamcasa\LeadEasyTest\User;
use InvalidArgumentException;

class App
{
    /**
     * this is a webhook url (use .env file to set the mock url)
     * @var string
     */
    private string $providerUrl;

    private ProviderPayloadContentType $contentType;

    private ProviderAuthorizationType $authorizationType;

    public function __construct()
    {
        $this->setProviderUrl(getenv('PROVIDER_WEBHOOK_ENDPOINT'));

        $contentType = $this->getContentTypeFromString(getenv('PROVIDER_CONTENT_TYPE'));
        $this->setContentType($contentType);

        $authorization = $this->getAuthorizationTypeFromString(getenv('PROVIDER_AUTHORIZATION_TYPE'));
        $this->setAuthorizationType($authorization);

    }

    public function getAuthorization(User $user): string
    {
        $prefix = getenv('PROVIDER_AUTHORIZATION_PREFIX');
        return sprintf('%s%s', $prefix, $user->getToken());
    }

    /**
     * returns the mock URL
     * @return string
     */
    public function getProviderUrl(): string
    {
        return $this->providerUrl;
    }

    /**
     * @param string $providerUrl
     * @return void
     * @throws InvalidArgumentException
     */
    private function setProviderUrl(string $providerUrl): void
    {
        if (filter_var($providerUrl, FILTER_VALIDATE_URL) === false) {
            $message = 'The PROVIDER_WEBHOOK_ENDPOINT is not valid. Review this information in .env file.';
            throw new InvalidArgumentException($message);
        }
        $this->providerUrl = $providerUrl;
    }

    /**
     * @param ProviderPayloadContentType $contentType
     * @return void
     */
    private function setContentType(ProviderPayloadContentType $contentType): void
    {
        $this->contentType = $contentType;
    }

    /**
     * @return ProviderPayloadContentType
     */
    public function getContentType(): ProviderPayloadContentType
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     * @return ProviderPayloadContentType
     */
    private function getContentTypeFromString(string $contentType): ProviderPayloadContentType
    {
        if ($contentType === ProviderPayloadContentType::JSON->name) {
            return ProviderPayloadContentType::JSON;
        }

        if ($contentType === ProviderPayloadContentType::FORM->name) {
            return ProviderPayloadContentType::FORM;
        }

        $message = 'The ProviderPayloadContentType is not valid. Review this information in .env file.';
        throw new InvalidArgumentException($message);
    }

    /**
     * @return ProviderAuthorizationType
     */
    public function getAuthorizationType(): ProviderAuthorizationType
    {
        return $this->authorizationType;
    }

    /**
     * @param string $authorization
     * @return ProviderAuthorizationType
     */
    private function getAuthorizationTypeFromString(string $authorization): ProviderAuthorizationType
    {
        if ($authorization === ProviderAuthorizationType::HEADER->name) {
            return ProviderAuthorizationType::HEADER;
        }

        if ($authorization === ProviderAuthorizationType::PAYLOAD->name) {
            return ProviderAuthorizationType::PAYLOAD;
        }

        $message = 'The ProviderAuthorization is not valid. Review this information in .env file.';
        throw new InvalidArgumentException($message);
    }

    /**
     * @param ProviderAuthorizationType $authorizationType
     * @return void
     */
    private function setAuthorizationType(ProviderAuthorizationType $authorizationType): void
    {
        $this->authorizationType = $authorizationType;
    }
}
