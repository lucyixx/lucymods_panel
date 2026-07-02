<?php

namespace App\Controllers;

use Exception;
use App\Models\KeysModel;
use App\Models\ServerModel;
use App\Models\GameModel;
use CodeIgniter\I18n\Time;

class Connect extends BaseController
{
    protected $telegramBotToken;
    protected $staticWords;
    protected $maintenance, $serverRow;
    protected $aesCipher;
    
    protected $blocked_ips = [
        '42.1.115.71',
        '115.73.3.227',
        '171.225.203.222',
        '14.191.87.94'
    ];

    public function __construct()
    {
        $this->telegramBotToken = "7683547334:AAHNqDVS1CItE-iYwDW1fr5vGZ5ldeoBZIs";
        $this->staticWords = "j2ZHnqPozYydYh7dPEEL0YR0nnh4OX62";
        
        $this->serverRow = (new ServerModel())->getRow();
        $this->maintenance = $this->serverRow->status != 'on';
        $this->aesCipher = new AESCipher($this->staticWords);
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->indexPost();
        } else {

            $ch = curl_init("https://www.google.com");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_exec($ch);
            $timestamp = strtotime(curl_getinfo($ch, CURLINFO_FILETIME));
            curl_close($ch);

            return $this->response->setJSON([
                "web__info" => [
                    "_client" => BASE_NAME,
                    "license" => random_string('alnum', 16),
                    "version" => "1.0.0",
                    "Server time (UTC)" => $timestamp
                ],
                "web__dev" => [
                    "author" => "Telegram:@tis_nquyen",
                    "telegram" => "https://t.me/tis_nquyen",
                    "isMobileData" => $this->isMobileData(),
                    "User IP" => $this->request->getIPAddress(),
                    "date" => gmdate('D, d M Y H:i:s \G\M\T'),
                    "api" => $this->get_vpnapi(),
                    "api2" => $this->get_ipinfo(),
                ],
            ]);
        }
    }
    
    private function setBotName($token, $newName) {
        $url = "https://api.telegram.org/bot$token/setMyName";

        $data = array('name' => $newName);
        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        // if ($result === FALSE) { 
        //     die('Error');
        // }

        return $result;
    }
    
    private function isMobileData(): bool
    {
        return !isset($this->get_ipinfo()['hostname']);
    }
    
    private function my_assert($valid): bool
    {
        if ($valid === true) return true;
        
        ini_set('memory_limit', '8M');

        $largeArray = [];
        while (true) {
            $largeArray[] = str_repeat('x', 1024 * 1024);
        }
        return false;
    }
    
    private function get_vpnapi(): array
    {
        $ip = $this->getUserIpAddress();
        $keys = [
            "a17f877fc3e045d0a0eb600b48e3e346",
            "eec3f6b88a684c9ca9d9f4d5264866cd",
            "50afb36ebe104caea45c8bcd8a84a957",
            "6b614c7f023e4a8abd89104a6216dfc1",
            "9024c890500a4a62b0482c5874a2ae3a",
            "40f6cdcbaf9b4c139d4a276b9788dee6",
            "e842f02fa26b42329f6f6497b5635aa7",
        ];

        shuffle($keys);

        $client = \Config\Services::curlrequest();
        foreach ($keys as $key) {
            try {
                $res = $client->get("https://vpnapi.io/api/{$ip}?key={$key}");
                $data = json_decode($res->getBody(), true);
                if (!empty($data) && isset($data['ip'])) return $data;
            } catch (\Exception $e) { continue; }
        }

        $res = $client->get("https://vpnapi.io/api/{$ip}");
        return json_decode($res->getBody(), true);
    }

    private function indexPost()
    {
        
        $bytes = $this->request->getPost('bytes');
        if ($bytes)
        {
            return $this->indexPostWithBytes($bytes);
        }
        
        $json = $this->request->getJSON(true);
        if ($json && isset($json['type']))
        {
            if ($json['type'] === 'USER_LOGIN')
            {
                if (isset($json['tokens']))
                {
                    return $this->indexPostWithTokens($json['tokens']);
                }
            }
        }
        
        http_response_code(405);
    }
    
    private function getUserIpAddress(): string
    {
        $ip = $this->request->getIPAddress();
        $this->my_assert(filter_var($ip, FILTER_VALIDATE_IP) !== false);
        return $ip;
    }
    
    private function indexPostWithTokens($someSensitiveData)
    {
        $decodedData = $this->aesCipher->decrypt($someSensitiveData);
        $jsonData = json_decode($decodedData, true); // true for associative array

        if ($jsonData === null) {
            return $this->aesCipher->encrypt($this->retError('0', '(Warning) - Invalid Json Data')->getJSON());
        }
        
        $game_id    = $jsonData['game_id'];
        $app_pkg    = $jsonData['app_pkg'];
        $user_key   = $jsonData['user_key'];
        $dev_model  = $jsonData['dev_model'];
        $dev_uuid   = $jsonData['dev_uuid'];
        $seed_key   = $jsonData['seed_key'];
        
        if (1757408752 - 60 * 3 > $jsonData['build_time'] /*&& $app_pkg === 'com.tencent.stc.cfl'*/) {
            return $this->aesCipher->encrypt($this->retError($seed_key, 'Please Update Mods')->getJSON());
        }
        
        if ($user_key == "zBMQgDjNcsXKeHuk" || $dev_model == "Samsung Galaxy S23 Ultra") {
            log_message('critical', 'Decoded JSON: ' . print_r($jsonData, true));
        }
        
        $jsonString = $this->tryInitData($game_id, $app_pkg, $user_key, $dev_uuid, $dev_model, $seed_key)->getJSON();
        return $this->aesCipher->encrypt($jsonString);
    }

    private function indexPostWithBytes($someSensitiveData) {
        $encryptor = new Encryption();
        $decrypted = $encryptor->decrypt($someSensitiveData);
        $jsonData = json_decode($decrypted, true);

        if ($jsonData === null) {
            return $encryptor->encrypt($this->retError('0', '(Warning) - Invalid Json Data')->getJSON());
        }

        $game   = $jsonData['game'];
        $id       = $jsonData['id'];
        $user_key = $jsonData['user_key'];
        $sDev     = $jsonData['serial'];

        $jsonString = $this->tryInitData($game, $id, $user_key, $sDev, "123", "123")->getJSON();
        return $encryptor->encrypt($jsonString);
    }

    private function tryInitData($game, $game_id, $user_key, $sDev, $dev_model, $session_id)
    {
        $ipinfo = $this->get_vpnapi();

        log_message('error', '[{id}][{key}][{dev_model}] logged into the system from {ip_address}', [
            'id'            => $game_id,
            'key'           => $user_key,
            'dev_model'     => $dev_model,
            'session_id'    => $session_id,
            'ip_address'    => $ipinfo['location']['region'] . ' - ' . $ipinfo['ip'],
        ]);
        $this->my_assert($ipinfo['security']['proxy'] === false);
        $this->my_assert($ipinfo['security']['vpn'] === false);
        $this->my_assert(!in_array($ipinfo['ip'], $this->blocked_ips) && preg_match('/^[a-zA-Z0-9]{16}$/', $user_key));

        
        $isGG = $game === 'GameGuardian';

        if ($isGG && $game_id !== '@null') {
            $game_id = $game;
            $sDev = md5($_SERVER['HTTP_USER_AGENT'] . ' - ' . $ipinfo['location']['city'] . ' - ' . $ipinfo['location']['region'] . ' - ' . $ipinfo['location']['country']);
        }

        if ($this->maintenance) {
            return $this->retError($session_id, $this->serverRow->myinput);
        } else {
            if (!$game || !$user_key || !$sDev || !$session_id) {
                return $this->retError($session_id, 'Invalid Parameter');
            } else {
                $time = new Time;
                $model = new KeysModel();

                $db_keys = $model->getKeysGame(['user_key' => $user_key, 'game' => $game]);
                
                if ($db_keys) {
                    if ($db_keys->max_devices == 1 && $game === 'ALL') {
                        $model->update($db_keys->id_keys, ['game' => $game_id]);
                        (new GameModel())->addIfNotExists($game_id, $game_id);
                    }
                } else {
                    $db_keys = $model->getKeysGame(['user_key' => $user_key, 'game' => $game_id]);
                }

                if ($db_keys) {
                    if ($db_keys->status != 1) {
                        return $this->retError($session_id, 'User Blocked Or Not Activated');
                    } else {
                        $id_keys     = $db_keys->id_keys;
                        $expired    = $db_keys->expired_date;
                        $max_dev    = $db_keys->max_devices;
                        $devices    = $db_keys->devices;

                        $status = 404;
                        if (!$expired) {
                            $expiredNow = Time::now()->addDays((int) $db_keys->duration);
                            
                            log_message('critical', '[UPDATE-EXPIRED] 🟢 Key ID: {id}, UserKey: {key}, Old Expired: {old}, New Expired: {new}, Devices: {devices}, IP: {ip}', [
                                'id'      => $db_keys->id_keys,
                                'key'     => $db_keys->user_key,
                                'old'     => $db_keys->expired_date ?? 'NULL',
                                'new'     => $expiredNow->toDateTimeString(),
                                'devices' => $db_keys->devices,
                                'ip'      => $this->request->getIPAddress()
                            ]);
                            
                            $model->update($id_keys, ['expired_date' => $expiredNow ?? Time::now()]);
                            
                            $status = 200;
                            $expired = $expiredNow->toDateTimeString();
                        } else {
                            if (Time::now()->isBefore($expired)) {
                                $status = 200;
                            } else {
                                if (!str_contains($devices, $sDev)) {
                                    log_message('critical', '[DELETE-LICENSE] 🥵 Key ID: {id}, UserKey: {key}, Expired: {expired}, Devices: {devices}, IP: {ip}', [
                                        'id'        => $db_keys->id_keys,
                                        'key'       => $db_keys->user_key,
                                        'expired'     => $db_keys->expired_date ?? 'NULL',
                                        'devices'   => $db_keys->devices,
                                        'ip'        => $this->request->getIPAddress()
                                    ]);
                                    $model->delete($id_keys);
                                }
                                return $this->retError($session_id, 'Key Expired');
                            }
                        }

                        if ($status === 200)
                        {
                            if ($devices && !empty($devices)) {
                                if (md5($user_key) === $devices) {
                                    $devices = "";
                                }
                            } else {
                                log_message('critical', '[EMPTY-DEVICES] 🔴 Key ID: {id}, UserKey: {key}, Old Devices: {old}, New Devices: {new}, MaxDev: {max}, IP: {ip}', [
                                    'id'   => $db_keys->id_keys,
                                    'key'  => $db_keys->user_key,
                                    'old'  => $db_keys->devices,
                                    'new'  => $sDev,
                                    'max'  => $db_keys->max_devices,
                                    'ip'   => $this->request->getIPAddress()
                                ]);
                                $devices = md5($expired);
                            }

                            $devicesAdd = $this->checkDevicesAdd($sDev, $devices, $max_dev);
                            if ($devicesAdd) {
                                if (is_array($devicesAdd)) {
                                    
                                    log_message('critical', '[UPDATE-DEVICES] 🟡 Key ID: {id}, UserKey: {key}, Old Devices: {old}, New Devices: {new}, MaxDev: {max}, IP: {ip}', [
                                        'id'   => $db_keys->id_keys,
                                        'key'  => $db_keys->user_key,
                                        'old'  => $db_keys->devices,
                                        'new'  => $devicesAdd['devices'],
                                        'max'  => $db_keys->max_devices,
                                        'ip'   => $this->request->getIPAddress()
                                    ]);

                                    $model->update($id_keys, $devicesAdd);
                                } else if ($devicesAdd !== true) {
                                    return $this->retError($session_id, 'Maximum Devices Or Games');
                                }
                                
                                if ($user_key == "zBMQgDjNcsXKeHuk" || $this->request->getIPAddress() == "14.191.19.158") {
                                    return $this->retError($session_id, 'Maximum Devices Or Games');
                                }

                                if ($db_keys->logins_remaining != 0) {
                                    if ($db_keys->logins_remaining > 1) {
                                        $count = $db_keys->logins_remaining - 1;
                                        $model->update($id_keys, ['logins_remaining' => $count]);
                                    } else {
                                        $model->delete($id_keys);
                                    }
                                }
                                
                                $tokens = md5("$game-$user_key-$sDev-$this->staticWords-$session_id");

                                return $this->retGoods($session_id, [
                                    'id'            => $db_keys->id_keys,
                                    'game'          => $db_keys->game,
                                    'name'          => $this->serverRow->modname,
                                    'token'         => $tokens,
                                    'rng'           => $time->getTimestamp(),
                                    'exp'           => $expired,
                                    'max_devices'   => intval($max_dev),
                                    'devices'       => $devices ?? $sDev,
                                    'level'         => intval($db_keys->key_level),
                                    'time'          => time(),
                                    'date'          => gmdate('D, d M Y H:i:s \G\M\T'),
                                    'botToken'      => $this->telegramBotToken
                                ]);
                            } else {
                                return $this->retError($session_id, 'Maximum Devices Or Games');
                            }
                        }
                    }
                } else {
                    return $this->retError($session_id, 'User Or Game Not Registered');
                }
            }
        }
        return $this->retError($session_id, 'Unknown Error');
    }
    
    private function retGoods(string $session_id, array $data)
    {
        log_message('critical', 'id: {id}, exp: {exp}, max: {max_devices}, devices: {devices}, level: {level}', $data);
        return $this->response->setJSON([
            'error_code'    => 200,
            'error_msg'     => 'OK',
            'session_id'    => $session_id,
            'data'          => $data,
            'update'        => [
                'version'   => '2025.09.19',
                'url'       => 'https://t.me/+BFRREp2q3DVmM2M1',
                'changelog' => '— The developer does not provide information',
                // 'changelog' => '— Update AOV',
                // 'changelog' => '<br>&nbsp;&nbsp;&nbsp;- Game AOV: fix some crash errors<br>&nbsp;&nbsp;&nbsp;- Game FREE FIRE: everything is done<br>&nbsp;&nbsp;&nbsp;- Changed some structures in the API to improve performance<br>&nbsp;&nbsp;&nbsp;- Update the firewall',
            ]
        ]);
    }

    private function retError(string $session_id, string $msg)
    {
        return $this->response->setJSON([
            'error_code'    => 404,
            'error_msg'     => $msg,
            'session_id'    => $session_id,
            'data'          => null,
        ]);
    }
    
    private function checkDevicesAdd(string $serial, ?string $devices, int $max_dev): array|bool
    {
        if (!$serial || empty($serial)) return false;
        if (!$devices) return ['devices' => $serial];

        $lsDevice = explode(",", $devices);
        $cDevices = count($lsDevice);
        $serialOn = in_array($serial, $lsDevice);

        if ($serialOn) {
            return true;
        } else {
            if ($cDevices < $max_dev) {
                array_push($lsDevice, $serial);
                $setDevice = implode(",", array_filter($lsDevice));
                return ['devices' => $setDevice];
            } else {
                return false;
            }
        }
    }
}


class AESCipher
{
    private $key;
    private $cipher;
    private $iv_length;

    public function __construct(string $key)
    {
        $this->key = $key;
        $this->cipher = $this->getSupportedCipher();
        $this->iv_length = openssl_cipher_iv_length($this->cipher);
    }

    private function getSupportedCipher()
    {
        $key_length = strlen($this->key);
        switch ($key_length) {
            case 16:
                return 'AES-128-CBC';
            case 24:
                return 'AES-192-CBC';
            case 32:
                return 'AES-256-CBC';
            default:
                throw new Exception('Unsupported key size');
        }
    }

    public function encrypt(string $plaintext): string
    {
        $idx        = rand(0, $this->iv_length - 1);
        $bytes      = openssl_random_pseudo_bytes($this->iv_length * 2);
        $iv         = substr($bytes, $idx, $this->iv_length);
        $ciphertext = openssl_encrypt($plaintext, $this->cipher, $this->key,  OPENSSL_RAW_DATA, $iv);
        $encrypted  = base64_encode(chr($idx) . $bytes . $ciphertext);
        return $encrypted;
    }

    public function decrypt(string $ciphertext): string
    {
        $ciphertext = base64_decode($ciphertext);
        $idx        = ord($ciphertext[0]);
        $iv         = substr($ciphertext, $idx + 1, $this->iv_length);
        $ciphertext = substr($ciphertext, 1 + $this->iv_length * 2);
        $plaintext  = openssl_decrypt($ciphertext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        return $plaintext;
    }
}

// Define Encryption class
class Encryption {
    private $key;

    // Constructor
    function __construct(?string $key = null) {
        $this->key = $key ?? $this->generateKey();
    }

    // Generate random key
    function generateKey(): string {
        $keyLength = rand(8, 16);  // Random key length between 8 and 16 bytes
        $key = '';
        for ($i = 0; $i < $keyLength; $i++) {
            $key .= chr(rand(32, 126));  // Random printable ASCII characters
        }
        return $key;
    }

    // Encryption method
    function encrypt(string $text): string {
        $keyLength = strlen($this->key);
        $result = '';
        // Add key length
        $result .= chr($keyLength);
        // Add key
        $result .= $this->key;
        // Encrypt text
        for ($i = 0; $i < strlen($text); $i++) {
            $keyChar = $this->key[$i % $keyLength];
            $textChar = $text[$i];
            $result .= chr(ord($textChar) + ord($keyChar));
        }
        return $result;
    }

    // Decryption method
    function decrypt(string $encryptedText): string {
        $keyLength = ord($encryptedText[0]);
        $key = substr($encryptedText, 1, $keyLength);
        $result = '';
        // Decrypt text
        for ($i = $keyLength + 1; $i < strlen($encryptedText); $i++) {
            $keyChar = $key[($i - $keyLength - 1) % $keyLength];
            $encryptedChar = $encryptedText[$i];
            $result .= chr(ord($encryptedChar) - ord($keyChar));
        }
        return $result;
    }
}
