<?php

namespace App\Rules;

use App\Models\Ranking;
use Illuminate\Contracts\Validation\Rule;

class RankingYearIsUnique implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($company_id)
    {
        $this->company_id = $company_id;
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
        $year = $value;
        $company_id = $this->company_id;

        if(!Ranking::where(['year' => $year, 'company_id' => $company_id])->first()){
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This company already has a ranking for :input.';
    }
}
