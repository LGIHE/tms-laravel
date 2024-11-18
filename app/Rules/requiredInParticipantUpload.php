<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RequiredInParticipantUpload implements Rule
{
    public $field;
    public $rowNumber;

    /**
     * Create a new rule instance.
     *
     * @param string $field
     * @param int $rowNumber
     * @return void
     */
    public function __construct($field, $rowNumber)
    {
        $this->field = $field;
        $this->rowNumber = $rowNumber;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $attribute && $value != null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The ' . $this->field . ' is required for every participant at row ' . $this->rowNumber;
    }
}
