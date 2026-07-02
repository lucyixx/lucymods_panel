<?php

/**
 * create_password
 *
 * @param string $password The input password to create a hash from.
 * @param bool $enc If true, returns the hashed password; otherwise, returns the original hash.
 * @return string The hashed password or the original hash.
 */
function create_password($password, $enc = true)
{
    $optn = ['cost' => 8];
    $patt = "XquxmymXDtWRA66D";
    $hash = md5($patt . $password);
    $pass = password_hash($hash, PASSWORD_DEFAULT, $optn);
    return ($enc ? $pass : $hash);
}

/**
 * getName
 *
 * @param object $user The user object containing the fullname and username.
 * @return string The user's name (either fullname or username).
 */
function getName($user)
{
    if ($user->fullname) {
        return word_limiter($user->fullname, 1, '');
    } else {
        return $user->username;
    }
}

/**
 * getLevelArray
 *
 * @return array The array of user roles.
 */
function getLevelArray()
{
    return ['&mdash; Select Roles &mdash;', 'Admin', 'Reseller'];
}

/**
 * getLevel
 *
 * @param int $level The user's level.
 * @return string The user's level name.
 */
function getLevel($level = 0)
{
    $levelArray = getLevelArray();
    return isset($levelArray[$level]) ? $levelArray[$level] : 'Unknown';
}

/**
 * setMessage
 *
 * @param string $msg The message to display.
 * @param string $color The color of the message (default is 'secondary').
 * @return array The message and its color as an array.
 */
function setMessage($msg, $color = 'secondary')
{
    return [$msg, $color];
}

/**
 * getDevice
 *
 * @param string $devices The devices as a comma-separated string.
 * @return object An object containing the total number of devices and the list of devices.
 */
function getDevice($devices)
{
    $total = 0;
    $listDevice = "";
    if ($devices) {
        $clean_comma = reduce_multiples($devices, ",", true);
        $ex = explode(',', $clean_comma);
        foreach ($ex as $ld) {
            $listDevice .= "$ld\n";
        }
        $total = count($ex);
    }
    return (object) ['total' => $total, 'devices' => trim($listDevice)];
}

/**
 * setDevice
 *
 * @param string $devicesPost The devices as a newline-separated string.
 * @param int $max The maximum number of devices allowed.
 * @return string|null The cleaned and formatted device string as a comma-separated list.
 */
function setDevice($devicesPost, $max)
{
    if ($devicesPost) {
        $deviceArray = explode("\n", $devicesPost);
        $filteredDevices = array_map(function ($device) {
            return preg_replace('/[^a-f0-9-]/', '', $device);
        }, $deviceArray);
        $filteredDevices = array_filter($filteredDevices);
        if (count($filteredDevices) > $max) {
            $filteredDevices = array_slice($filteredDevices, 0, $max);
        }
        return implode(',', $filteredDevices);
    }
    return null;
}

/**
 * getPrice
 *
 * @param array $price An array of prices based on duration.
 * @param string $duration The selected duration.
 * @param int $device_max The maximum number of devices.
 * @return mixed The calculated price or false if the result is not greater than 0.
 */
function getPrice($price, $duration, $device_max)
{
    $priceReal = $price[$duration];
    $result = ($priceReal * $device_max);
    return ($result <= 0) ? false : $result;
}

function calculatePrice(int $days, bool $isUsd = false): float
{
    $ratio = 5;
    if ($isUsd) {
        $min = 3;
    } else {
        $min = 75;
    }
    $max = $min*$ratio;
    return round($min + (($days) * (($max - $min) / (30/*-1*/))), 1);
}

