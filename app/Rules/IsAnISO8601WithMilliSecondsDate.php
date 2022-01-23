<?php

namespace App\Rules;

use App\Helpers\DateFormatsHelper;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class IsAnISO8601WithMilliSecondsDate implements Rule
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
        if ((! is_string($value) && ! is_numeric($value)) || strtotime($value) === false) {
            return false;
        }

        $parsedDate = date_parse($value);
        if (! checkdate($parsedDate['month'], $parsedDate['day'], $parsedDate['year'])) {
            return false;
        }

        $fractionOfSecondsLength = Str::of((double) $parsedDate['fraction'])->length();
        if ($fractionOfSecondsLength === 1 || $fractionOfSecondsLength === 5 || $fractionOfSecondsLength === 8) {
            try {
                $date = Carbon::createFromFormat(
                    '!' . DateFormatsHelper::ISO8601_WITH_MICRO_SECONDS,
                    $value
                );

                $toIso8601ZuluString = $date->toIso8601ZuluString('millisecond');
                if ($fractionOfSecondsLength === 8) {
                    $toIso8601ZuluString = $date->toIso8601ZuluString('microsecond');
                }

                return $date && $toIso8601ZuluString == $value;
            } catch (\Exception $e) {
                return false;
            }
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
        return sprintf(
            '%s %s %s %s %s',
            'The value supplied for the :attribute field appears to be invalid.',
            'The system is expecting both',
            'a range between 1000-01-01 00:00:00.000, 9999-12-31 23:59:59.999 or 1000-01-01 00:00:00.000000, 9999-12-31 23:59:59.999999',
            'and an ISO-8601 full-precision format with exact length of 3 or 6 for the seconds fraction.',
            'Example: 1900-02-03T23:00:00.123Z or 1900-02-03T23:00:00.123456Z'
        );
    }
}
