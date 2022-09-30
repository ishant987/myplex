<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsValidPicture implements Rule
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
        if($value)
        {         
            if(stristr($value, ".")){
                $extArr = array('png','jpeg','jpg');
                $imgInfoArr = pathinfo($value);
                if(!empty($imgInfoArr)){
                    $ext = strtolower($imgInfoArr['extension']);
                    if($ext){
                        if(!in_array($ext, $extArr)){
                            return false;
                        } 
                    }
                    else{
                        return false;
                    }
                }
                else{
                    return false;
                }
            }
            else{
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
