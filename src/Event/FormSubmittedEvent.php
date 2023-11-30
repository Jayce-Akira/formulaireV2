<?php
namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class FormSubmittedEvent extends Event
{
    private $formData;

    public function __construct(array $formData)
    {
        $this->formData = $formData;
    }

    public function getFormData(): array
    {
        return $this->formData;
    }
}