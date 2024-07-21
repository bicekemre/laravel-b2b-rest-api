<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TcNo implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (!is_numeric($value) || strlen($value) != 11) {
            return false;
        }

        $digits = str_split($value);
        if ($digits[0] == 0) {
            return false;
        }

        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8];
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7];

        if (($odd_sum * 7 - $even_sum) % 10 != $digits[9]) {
            return false;
        }

        $total_sum = array_sum(array_slice($digits, 0, 10));
        if ($total_sum % 10 != $digits[10]) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute is not a valid T.C. Identity Number.';
    }
}
