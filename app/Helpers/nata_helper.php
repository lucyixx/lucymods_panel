<?php

/**
 * GameData
 *
 * Simple value object describing one supported game. Currently backed by
 * a hardcoded list in getSupportedGames() below; the intent is for that
 * function to eventually query a real "games" table instead.
 */
class GameData
{
    public string $name;
    public string $image_url;
    public string $id;
    public array $modes;
    public array $features;
    public function __construct(string $name, string $image_url, string $id, array $modes, array $features)
    {
        $this->name = $name;
        $this->image_url = $image_url;
        $this->id = $id;
        $this->modes = $modes;
        $this->features = $features;
    }
}

/**
 * getSupportedGames
 *
 * Returns the full list of supported games. Shared by home.php (which only
 * shows the first few) and games.php (which lists all of them), so there is
 * a single source of truth. Replace the body with a real query once games
 * are managed from the database instead of hardcoded here.
 *
 * @return GameData[]
 */
function getSupportedGames(): array
{
    return [
        new GameData(
            "Call of Duty: Mobile",
            "https://play-lh.googleusercontent.com/zX7jmUbnCkH1LlhGFIffDv76OgJjIy3zZvzC6DPO-Cl-BPXfNVluTCDHTX6YSpvxKUrd=w240-h480-rw",
            "com.activision.callofduty.shooter",
            ["Zygisk Module", "Inject"],
            ["Draw Esp (Line, Name, Box, Head...)", "AimBot", "Bullet Track"]
        ),
        new GameData(
            "Free Fire Max",
            "https://play-lh.googleusercontent.com/La2XvLnJqNI5JyshQ5RfxM18zHduji9KPgNge93Ibwpjc7znBZVYuuwJ4ycGk6T-DQ=w240-h480-rw",
            "com.dts.freefiremax",
            ["Zygisk Module", "Inject"],
            ["Draw Esp", "Aimbot"]
        ),
        new GameData(
            "Garena Liên Quân Mobile",
            "https://play-lh.googleusercontent.com/S3GPwY1-mc5876ZnMk65-VrG3Xlh1R8zgK-Q_LlnbjZ7llyyv0ZGWIlNnBM7LckMMzYy=w240-h480-rw",
            "com.garena.game.kgvn",
            ["Zygisk Module", "Inject"],
            ["Hack Map", "Show Icon Info"]
        ),
        new GameData(
            "Arena of Valor",
            "https://play-lh.googleusercontent.com/3Qs6i05oAAUtjzwZCi0AJ9FpxT85w5BWCedIXCrsVKLTGOCcnP2B5yOVoheGSBZpj8z9=w240-h480-rw",
            "com.ngame.allstar.eu",
            ["Zygisk Module", "Inject"],
            ["Hack Map", "Show Icon Info"]
        ),
        new GameData(
            "Free Fire",
            "https://play-lh.googleusercontent.com/QjALB_Hon-W8P8OdoGrZ3DESdm7q4Lx8_pPyqckrIvHop3BKpD1bsc2wubwJ2yfCJyI=w240-h480-rw",
            "com.dts.freefireth",
            ["Zygisk Module", "Inject"],
            ["Draw Esp", "Aimbot"]
        ),
        new GameData(
            "콜 오브 듀티: 모바일",
            "https://play-lh.googleusercontent.com/ZNtLvGqEhudE8aRFz6aZm4u4TJ_BNx7gUQQwvSXHZX6LHzN-tUX2advKOjLcnS6Odc8=w240-h480-rw",
            "com.tencent.tmgp.kr.codm",
            ["Zygisk Module", "Inject"],
            ["Draw Esp (Line, Name, Box, Head...)", "AimBot", "Bullet Track"]
        ),
        new GameData(
            "Call of Duty®: Mobile - Garena",
            "https://play-lh.googleusercontent.com/lyThPUTIsMNZFyXLxlb_zNS6nGocTLV9IUzbMfdmaikAdHz8enJrg9rAeGcXUljqa0Y=w240-h480-rw",
            "com.garena.game.codm",
            ["Zygisk Module", "Inject"],
            ["Draw Esp (Line, Name, Box, Head...)", "AimBot", "Bullet Track"]
        ),
        new GameData(
            "Call Of Duty: Mobile VN",
            "https://play-lh.googleusercontent.com/Z5oz3yGm79jlshxT_RlZmgr0j-FVPbppMkF9E28iCBLi5AgtBIhLhZM1H48GSbyVmbA=w240-h480-rw",
            "com.vng.codmvn",
            ["Zygisk Module", "Inject"],
            ["Draw Esp (Line, Name, Box, Head...)", "AimBot", "Bullet Track"]
        ),
        new GameData(
            "Garena AOV",
            "https://play-lh.googleusercontent.com/caDiIvFl-VDvEPlzbHuypmXMTIwAiA8WesvsUIcFoQqokLaYRSYh-Y0LpR4RFhGgytEg=w240-h480-rw",
            "com.garena.game.kgid",
            ["Zygisk Module", "Inject"],
            ["Hack Map", "Show Icon Info"]
        ),
    ];
}

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
    $patt = "x8C-6X7_0c@%Ha";
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

