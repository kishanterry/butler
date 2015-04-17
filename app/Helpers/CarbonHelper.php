<?php

/**
 * Check if the provided date is a weekend
 * @param $date
 * @return bool
 */
function is_weekend($date)
{
    $date = make_carbon($date);
    /**
     * SUNDAY = 0 in Carbon
     */
    if ($date->dayOfWeek === 0) {
        return true;
    }

    return false;
}

function day_of_week($date)
{
    $date = make_carbon($date);

    return $date->format('D');
}

/**
 * Return a Carbon Instance of $date or fail
 *
 * @param $date
 * @return static
 */
function make_carbon($date)
{
    if (is_numeric($date)) {
        return $date = \Carbon\Carbon::now()->day($date);
    }

    return \Carbon\Carbon::createFromFormat('Y-m-d', $date);
}