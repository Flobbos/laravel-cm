<?php

namespace Flobbos\LaravelCM\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class CommaSeparatedEmails implements ValidationRule
{
    public function __construct(
        protected int $maxCount = 5
    ) {}

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $emails = array_map('trim', explode(',', (string) $value));

        if (count($emails) > $this->maxCount) {
            $fail("The :attribute may not contain more than {$this->maxCount} email addresses.");
            return;
        }

        foreach ($emails as $email) {
            $validator = Validator::make(['email' => $email], ['email' => 'required|email']);
            if ($validator->fails()) {
                $fail("The :attribute contains an invalid email address: \"{$email}\".");
                return;
            }
        }
    }
}
