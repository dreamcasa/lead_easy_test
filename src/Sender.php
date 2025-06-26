<?php

namespace Dreamcasa\LeadEasyTest;

use Dreamcasa\LeadEasyTest\AppProvider\App;
use Dreamcasa\LeadEasyTest\AppProvider\ProviderAuthorizationType;
use Dreamcasa\LeadEasyTest\AppProvider\ProviderPayloadContentType;

class Sender
{
    /**
     * @param App $appProvider
     * @param LeadData $leadData
     * @param User $user
     * @param int $limit
     * @return void
     */
    public function sendLead(App $appProvider, LeadData $leadData, User $user, int $limit = 30): void
    {
        $timeout = $limit < 30? 30 : $limit*0.8;
        $headerArray = [
            'Content-type' => $appProvider->getContentType()->value,
            'Connection' => 'close'
        ];

        // add header authorization case selected
        if ($appProvider->getAuthorizationType() === ProviderAuthorizationType::HEADER) {
            $headerArray['Authorization'] = $appProvider->getAuthorization($user);
        }

        // add payload(body) authorization case selected
        $dataArray = $leadData->toArray();
        if ($appProvider->getAuthorizationType() === ProviderAuthorizationType::PAYLOAD){
            $dataArray['token'] = $appProvider->getAuthorization($user);
        }

        $data = $this->getDataStringContentTypeFormatted($dataArray, $appProvider->getContentType());
        $headersString = $this->getHeaderStringFormatted($headerArray, $data);

        $context = stream_context_create(array('http' =>
            array(
                'timeout' => $timeout,
                'method' => 'POST',
                'header' => $headersString,
                'content' => $data
            )
        ));
        $providerUrl = $appProvider->getProviderUrl();
        file_get_contents($providerUrl,0, $context);
    }

    /**
     * Create header string
     * @param array $headers
     * @param string $data
     * @return string
     */
    private function getHeaderStringFormatted(array $headers, string $data): string
    {
        $headersString = '';
        foreach ($headers as $key => $value){
            $headersString .= sprintf("%s: %s\r\n", $key, $value);
        }
        $headersString .= sprintf('Content-Length: %s', strlen($data))."\r\n";
        return $headersString;
    }

    /**
     * Format the data based on contentType requested
     * @param array $data
     * @param ProviderPayloadContentType $contentType
     * @return string
     */
    private function getDataStringContentTypeFormatted(array $data, ProviderPayloadContentType $contentType): string
    {
        if($contentType === ProviderPayloadContentType::FORM){
            return http_build_query($data);
        }
        if($contentType === ProviderPayloadContentType::JSON){
            return json_encode($data);
        }
        return '';
    }
}
