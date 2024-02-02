<?php
namespace Zyimm\Pojo;

if (!function_exists('to_camel_case')) {
    function to_camel_case($input): string
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
