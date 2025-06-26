<?php

namespace Dreamcasa\LeadEasyTest;

class LeadData
{
    private string $reference;
    private string $name;
    private string $email;
    private string $phone;
    private string $message;

    /**
     * @param string $reference
     * @param string $name
     * @param string $email
     * @param string $phone
     * @param string $message
     * @return self
     */
    public static function factory(
        string $reference,
        string $name,
        string $email,
        string $phone,
        string $message
    ): self {
        $lead = new LeadData();

        $lead->reference = $reference;
        $lead->name = $name;
        $lead->email = $email;
        $lead->phone = $phone;
        $lead->message = $message;

        return $lead;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "reference" => $this->reference,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "message" => $this->message
        ];
    }
}
