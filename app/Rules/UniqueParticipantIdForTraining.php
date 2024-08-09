<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueParticipantIdForTraining implements Rule
{
    public $trainingId;
    public $participantId;
    public $participantIdField;
    public $trainingsField;

    /**
     * Create a new rule instance.
     *
     * @param string $trainingId
     * @param string $participantId
     * @param string $participantIdField
     * @param string $trainingsField
     * @return void
     */
    public function __construct($trainingId, $participantId, $participantIdField = 'id_no', $trainingsField = 'trainings')
    {
        $this->trainingId = $trainingId;
        $this->participantId = $participantId;
        $this->participantIdField = $participantIdField;
        $this->trainingsField = $trainingsField;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Fetch participants with the same id_no
        $participants = DB::table('participants')
            ->where($this->participantIdField, $value)
            ->get();

        $this->participantId = $value;

        // Check if any participant has the same training id
        foreach ($participants as $participant) {
            $trainings = json_decode($participant->{$this->trainingsField}, true);
            if (is_array($trainings)) {
                foreach ($trainings as $training) {
                    if (isset($training['training_id']) && $training['training_id'] == $this->trainingId) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The participant with this ID No. ' . $this->participantId . ' is already registered for this training.';
    }
}
