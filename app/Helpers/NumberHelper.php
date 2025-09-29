<?php

if (!function_exists('safe_number_format')) {
    /**
     * Format number safely, handling non-numeric values
     *
     * @param mixed $value
     * @param int $decimals
     * @param string $decimal_separator
     * @param string $thousands_separator
     * @return string
     */
    function safe_number_format($value, $decimals = 0, $decimal_separator = '.', $thousands_separator = ',')
    {
        // Handle null, empty, or false values
        if (is_null($value) || $value === '' || $value === false) {
            return number_format(0, $decimals, $decimal_separator, $thousands_separator);
        }
        
        // If already numeric, format directly
        if (is_numeric($value)) {
            return number_format((float) $value, $decimals, $decimal_separator, $thousands_separator);
        }
        
        // Try to clean string values
        $cleaned = preg_replace('/[^0-9.-]/', '', $value);
        if (is_numeric($cleaned)) {
            return number_format((float) $cleaned, $decimals, $decimal_separator, $thousands_separator);
        }
        
        // Fallback to 0
        return number_format(0, $decimals, $decimal_separator, $thousands_separator);
    }
}

if (!function_exists('safe_numeric')) {
    /**
     * Convert value to safe numeric format
     *
     * @param mixed $value
     * @param float $default
     * @return float
     */
    function safe_numeric($value, $default = 0)
    {
        if (is_null($value) || $value === '' || $value === false) {
            return $default;
        }
        
        if (is_numeric($value)) {
            return (float) $value;
        }
        
        // Try to clean string values
        $cleaned = preg_replace('/[^0-9.-]/', '', $value);
        if (is_numeric($cleaned)) {
            return (float) $cleaned;
        }
        
        return $default;
    }
}
