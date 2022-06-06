<?php

declare(strict_types=1);

const MATCHING_CNP = '279146358279';

/**
 * @param string $value
 * @return bool
 */

function isCnpValid(string $value): bool
{
    //split value string to array
    $arrayValue = str_split($value);

    //convert matching CPN  to array
    $matchingArray = str_split(MATCHING_CNP);

    //check if value has 13 characters
    //check if first 12 characters match cnp rules
    preg_match('/^[1-9]\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])(0[1-9]|[1-3]\d|4[0-6]|5[1-2])(00[1-9]|0[1-9]\d|[1-9]\d\d)\d$/', $value, $output_array);
    if(!$output_array) return false;

    //check if birth date is valid
    switch ($arrayValue[0])
    {
        case 1:
        case 2:
        case 7:
        case 8:
        case 9:
            $year = '19'.$arrayValue[1].$arrayValue[2];
            break;
        case 3:
        case 4:
            $year = '20'.$arrayValue[1].$arrayValue[2];
            break;
        default:
            $year = '18'.$arrayValue[1].$arrayValue[2];
    }
    $month = $arrayValue[3].$arrayValue[4];
    $day = $arrayValue[5].$arrayValue[6];

    if(!checkdate((int) $month, (int) $day, (int) $year)){
        return false;
    }

    //remove last element aka control int
    $controlInt = array_pop($arrayValue);

    //multiply each element of arrayValue with matchingArray
    $arrayValue = array_map(function ($a, $b){
        return $a * $b;
    }, $arrayValue, $matchingArray);

    //calculate the sum of values
    $arraySum = array_sum($arrayValue);

    //validate control int
    if(($arraySum % 11 !== 10 ? $arraySum % 11 : 1) != $controlInt){
        return false;
    }

    return true;
}

/**
 * @return string
 */

function generateCnp() : string
{
    //generate random values
    $gender = mt_rand(1,9);
    $year = sprintf("%02d", mt_rand(1,99));
    $month = sprintf("%02d", mt_rand(1,12));
    $day = sprintf("%02d", mt_rand(1,28));
    $county = sprintf("%02d", mt_rand(1,52));
    //check if county matches one of unassigned numbers
    if(in_array($county, [47,48,49,50])){
        $county = $county - mt_rand(4,10);
    }
    $rand = sprintf("%03d", mt_rand(001,999));

    //concat 12 char number
    $code = $gender.$year.$month.$day.$county.$rand;

    //split value string to array
    $arrayValue = str_split($code);

    //convert matching CPN  to array
    $matchingArray = str_split(MATCHING_CNP);

    //multiply each element of arrayValue with matchingArray
    $arrayValue = array_map(function ($a, $b){
        return $a * $b;
    }, $arrayValue, $matchingArray);

    //calculate the sum of values
    $arraySum = array_sum($arrayValue);

    //concat code with control int
    $code = $code.($arraySum % 11 !== 10 ? $arraySum % 11 : 1);

    return $code;
}