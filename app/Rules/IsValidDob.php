<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsValidDob implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if ($value != '') {
            $birthdayArr = explode("-", $value);
            if (is_array($birthdayArr) && count($birthdayArr) > 0) {
                $bdayDay = isset($birthdayArr[0]) ? trim((int)$birthdayArr[0]) : '';
                $bdayMonth = isset($birthdayArr[1]) ? trim((int)$birthdayArr[1]) : '';

                if ($bdayDay == 0 || $bdayMonth == 0) {
                    return false;
                }
                if ($bdayDay < 0 || $bdayMonth < 0) {
                    return false;
                }
                if (($bdayDay > 31) || ($bdayMonth > 12)) {
                    return false;
                }
                if ($bdayDay == '' || $bdayMonth == '') {
                    return false;
                }
            } else {
                return false;
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
        return 'The :attribute validation error.';
    }
}
