<?php
namespace Zyimm\Pojo;

if (!function_exists('to_camel_case')) {
    /**
     * to_camel_case
     *
     * @param string $input
     *
     * @return string
     */
    function to_camel_case(string $input): string
    {
        $parts  = explode('_', $input);
        $result = $parts[0];
        $count  = count($parts);
        for ($i = 1; $i < $count; $i++) {
            $result .= ucfirst($parts[$i]);
        }
        return $result;
    }
}
