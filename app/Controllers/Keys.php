<?php

namespace App\Controllers;

use App\Models\GameModel;
use App\Models\HistoryModel;
use App\Models\KeysModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;
use Config\Services;
use App\Enums\Level;

class Keys extends BaseController
{
    protected $userModel, $model, $user, $time;
    protected $game_list = [
        ''              => '&mdash; Select Game &mdash;',
        'ALL'           => 'All Games',
        'GameGuardian'  => 'Lua GameGuardian',
    ];
    protected $duration = [
        1   => '1 Days',
        7   => '7 Days',
        30  => '30 Days',
        60  => '60 Days',
    ];
    protected $levels = [
        1   => 'Free',
        2   => 'Vip',
        3   => 'Normal'
    ];
    protected $price = [
        1   => 5,
        7   => 10,
        30  => 20,
        60  => 35,
    ];

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->user = $this->userModel->getUser();
        $this->model = new KeysModel();
        $this->time = new Time;
        $gameModel = new GameModel;
        $this->game_list = $gameModel->getGameMap($this->game_list);

        if (isset($this->user->level) && $this->user->level != 1) {
            array_pop($this->game_list);
            array_pop($this->levels);
        }
    }

    public function index()
    {
        $model = $this->model;
        $user = $this->user;

        if ($user->level != 1) {
            $keys = $model->where('registrator', $user->username)->findAll();
        } else {
            $keys = $model->findAll();
        }

        $data = [
            'title' => 'Keys',
            'user' => $user,
            'keylist' => $keys,
            'time' => $this->time,
            'game' => $this->game_list,
            'levels' => $this->levels,
            'duration' => $this->duration,
            'price' => json_encode($this->price),
        ];
        return view('Keys/list', $data);
    }


    public function download_all_Keys()
    {
        $keys = $this->model->select('user_key')->findAll();
        $data = '';
        for ($i = 0; $i < count($keys); $i++) {
            $data .= $keys[$i]['user_key'] . "\n";
        }
        write_file('Newkeys.txt', $data);
        $this->downloadFile('Newkeys.txt');
        unlink("Newkeys.txt");
    }


    public function download_new_Keys()
    {
        $dtm = date('Y-m-d H:i:s');
        $this->downloadFile("New.txt");
    }

    function downloadFile($yourFile)
    {
        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }

        $file = @fopen($yourFile, "rb");
        $dtm = date('Y-m-d H:i:s');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=$dtm.txt");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($yourFile));
        while (!feof($file)) {
            print(@fread($file, 1024 * 8));
            ob_flush();
            flush();
        }
    }

    public function delExpkeys()
    {
        if ($this->user->level == 1) {
            $this->model->where('expired_date <',  date('Y-m-d H:i:s'))->delete();
        } else {
            return redirect()->back()->with('msgDanger', 'Only Admin can delete the Keys.');
        }
        return redirect()->back()->with('msgSuccess', 'Delete Keys Expired Success.');
    }

    //delete wasted keys
    public function startDate()
    {
        if ($this->user->level == 1) {
            $this->model->where('expired_date =' . null)->delete();
        } else {
            return redirect()->back()->with('msgDanger', 'Only Admin can delete the Keys.');
        }
        return redirect()->back()->with('msgSuccess', 'Delete Keys Not Use Success');
    }

    public function api_get_keys()
    {
        return $this->model->API_getKeys();
    }

    public function api_key_delete()
    {
        sleep(1);
        $model = $this->model;
        $keys = $this->request->getGet('userkey');
        $delete = $this->request->getGet('delete');
        $db_key = $model->getKeys($keys);

        $rules = [];
        $user = $this->user;
        if ($delete) {
            if ($user->level == 1 || $user->level == 2) {
                $model->where('user_key', $keys)->delete();
                $rules = ['delete' => true];
            } else {
            }
        }

        $data = [
            'registered' => $db_key ? true : false,
            'keys' => $keys,
        ];

        $real_response = array_merge($data, $rules);
        return $this->response->setJSON($real_response);
    }

    public function api_key_reset()
    {
        sleep(1);
        $model = $this->model;
        $keys = $this->request->getGet('userkey');
        $reset = $this->request->getGet('reset');
        $db_key = $model->getKeys($keys);

        $rules = [];
        if ($db_key) {
            $total = $db_key->devices ? explode(',', $db_key->devices) : [];
            $rules = ['devices_total' => count($total), 'devices_max' => (int) $db_key->max_devices];
            $user = $this->user;
            if ($db_key->devices && $reset) {
                if ($user->level == 1 || $db_key->registrator == $user->username) {
                    $model->set('devices', md5($keys))
                        ->where('user_key', $keys)
                        ->update();
                    $rules = ['reset' => true, 'devices_total' => 0, 'devices_max' => $db_key->max_devices];
                }
            } else {
            }
        }

        $data = [
            'registered' => $db_key ? true : false,
            'keys' => $keys,
        ];

        $real_response = array_merge($data, $rules);
        return $this->response->setJSON($real_response);
    }

    public function edit_key($key = false)
    {
        if ($this->request->getPost()) {
            return $this->edit_key_action();
        }

        $msgDanger = "The user key no longer exists.";
        if ($key) {
            $db_key = $this->model->getKeys($key, 'id_keys');
            $user = $this->user;
            if ($db_key) {
                if ($user->level == 1 || $db_key->registrator == $user->username) {
                    $validation = Services::validation();
                    $data = [
                        'title' => 'Key',
                        'user' => $user,
                        'key' => $db_key,
                        'levels' => $this->levels, // Level::asArray(),
                        'game_list' => $this->game_list,
                        'time' => $this->time,
                        'key_info' => getDevice($db_key->devices),
                        'messages' => setMessage('Please carefuly edit information'),
                        'validation' => $validation,
                    ];
                    return view('Keys/key_edit', $data);
                } else {
                    $msgDanger = "Restricted to this user key.";
                }
            }
        }
        return redirect()->to('keys')->with('msgDanger', $msgDanger);
    }

    private function edit_key_action()
    {
        $keys = $this->request->getPost('id_keys');
        $user = $this->user;
        $db_key = $this->model->getKeys($keys, 'id_keys');
        $game = implode(",", array_keys($this->game_list));

        if (!$db_key) {
            $msgDanger = "The user key no longer exists~";
        } else {
            if ($user->level == 1 || $db_key->registrator == $user->username) {
                $form_reseller = [
                    'status' => [
                        'label' => 'status',
                        'rules' => 'required|integer|in_list[0,1]',
                        'erros' => [
                            'integer' => 'Invalid {field}.',
                            'in_list' => 'Choose between list.'
                        ]
                    ]
                ];
                $form_admin = [
                    'id_keys' => [
                        'label' => 'keys',
                        'rules' => 'required|is_not_unique[keys_code.id_keys]|numeric',
                        'errors' => [
                            'is_not_unique' => 'Invalid keys.'
                        ],
                    ],
                    'game' => [
                        'label' => 'Games',
                        'rules' => "required|in_list[$game]",
                        'errors' => [
                            'alpha_numeric_space' => 'Invalid characters.'
                        ],
                    ],
                    'user_key' => [
                        'label' => 'User keys',
                        'rules' => "required|is_unique[keys_code.user_key,user_key,$db_key->user_key]|alpha_numeric",
                        'errors' => [
                            'is_unique' => '{field} has been taken.'
                        ],
                    ],
                    'duration' => [
                        'label' => 'duration',
                        'rules' => 'required|numeric|greater_than_equal_to[1]',
                        'errors' => [
                            'greater_than_equal_to' => 'Minimum {field} is invalid.',
                            'numeric' => 'Invalid day {field}.'
                        ]
                    ],
                    'max_devices' => [
                        'label' => 'Max devices',
                        'rules' => 'required|numeric|greater_than_equal_to[1]',
                        'errors' => [
                            'greater_than_equal_to' => 'Minimum {field} is invalid.',
                            'numeric' => 'Invalid max of {field}.'
                        ]
                    ],
                    'logins_remaining' => [
                        'label' => 'Logins remaining',
                        'rules' => 'required|numeric|greater_than_equal_to[0]',
                        'errors' => [
                            'greater_than_equal_to' => 'Minimum {field} is invalid.',
                            'numeric' => 'Invalid max of {field}.'
                        ]
                    ],
                    'registrator' => [
                        'label' => 'registrator',
                        'rules' => 'permit_empty|alpha_numeric_space|min_length[4]'
                    ],
                    'expired_date' => [
                        'label' => 'Expired Date',
                        'rules' => [
                            'permit_empty',
                            'valid_date[Y-m-d\TH:i]',
                            function ($datetime) {
                                $current_datetime = date('Y-m-d\TH:i');
                                return strtotime($datetime) > strtotime($current_datetime);
                            },
                        ],
                        'errors' => [
                            'valid_date' => 'Invalid {field} date.',
                            'expired_date' => 'The {field} must be a date and time greater than the current time.',
                        ],
                    ],
                    'devices' => [
                        'label' => 'device list',
                        'rules' => 'permit_empty'
                    ]
                ];

                if ($user->level == 1) {
                    // Admin full rules.
                    $form_rules = array_merge($form_reseller, $form_admin);
                    $devices = $this->request->getPost('devices');
                    $max_devices = $this->request->getPost('max_devices');

                    $data_saves = [
                        'game' => $this->request->getPost('game'),
                        'user_key' => $this->request->getPost('user_key'),
                        'duration' => $this->request->getPost('duration'),
                        'key_level' => $this->request->getPost('key_level'),
                        'max_devices' => $max_devices,
                        'logins_remaining' => $this->request->getPost('logins_remaining'),
                        'status' => $this->request->getPost('status'),
                        'registrator' => $this->request->getPost('registrator'),
                        'expired_date' => $this->request->getPost('expired_date') ?: NULL,
                        'devices' => setDevice($devices, $max_devices),
                    ];
                } else {
                    // Reseller just status rules, you can set manually later.
                    $form_rules = $form_reseller;
                    $data_saves = [
                        'status' => $this->request->getPost('status'),
                        'duration' => $this->request->getPost('duration'),
                        'user_key' => $this->request->getPost('user_key'),
                        'duration' => $this->request->getPost('duration'),
                    ];
                }

                if (!$this->validate($form_rules)) {
                    return redirect()->back()->withInput()->with('msgDanger', $this->validator->listErrors());
                } else {
                    $this->model->update($db_key->id_keys, $data_saves);
                    return redirect()->back()->with('msgSuccess', 'User key successfuly updated!');
                }
            } else {
                $msgDanger = "Restricted to this user key~";
            }
        }
        return redirect()->to('keys')->with('msgDanger', $msgDanger);
    }

    public function generate()
    {
        if ($this->request->getPost())
            return $this->generate_action();

        $user = $this->user;
        $validation = Services::validation();

        $message = setMessage("<i class='bi bi-wallet'></i> Total Saldo $$user->saldo");
        if ($user->saldo <= 0) {
            $message = setMessage("Please top up to your beloved admin.", 'warning');
        }

        $data = [
            'title' => 'Generate',
            'user' => $user,
            'time' => $this->time,
            'game' => $this->game_list,
            'levels' => $this->levels, // Level::asArray(),
            'duration' => $this->duration,
            'price' => json_encode($this->price),
            'messages' => $message,
            'validation' => $validation,
        ];
        return view('Keys/generate', $data);
    }

    private function generate_action()
    {
        $user = $this->user;
        $game = $this->request->getPost('game');
        $maxd = $this->request->getPost('max_devices');
        $ukey = $this->request->getPost('user_key');
        $levl = $this->request->getPost('key_level');
        $drtn = $this->request->getPost('duration');
        $getPrice = getPrice($this->price, $drtn, $maxd);

        $game_list = implode(",", array_keys($this->game_list));
        $form_rules = [
            'game' => [
                'label' => 'Games',
                'rules' => "required|in_list[$game_list]",
                'errors' => [
                    'alpha_numeric_space' => 'Invalid characters.'
                ],
            ],
            'duration' => [
                'label' => 'duration',
                'rules' => 'required|numeric|greater_than_equal_to[1]',
                'errors' => [
                    'greater_than_equal_to' => 'Minimum {field} is invalid.',
                    'numeric' => 'Invalid day {field}.'
                ]
            ],
            'max_devices' => [
                'label' => 'devices',
                'rules' => 'required|numeric|greater_than_equal_to[1]',
                'errors' => [
                    'greater_than_equal_to' => 'Minimum {field} is invalid.',
                    'numeric' => 'Invalid max of {field}.'
                ]
            ],
        ];

        $validation = Services::validation();
        $reduceCheck = ($user->saldo - $getPrice);
        
        
        // dd($reduceCheck);
        if ($reduceCheck < 0) {
            $validation->setError('duration', 'Insufficient balance');
            return redirect()->back()->withInput()->with('msgWarning', 'Please top up to your beloved admin.');
        } else {
            if (!$this->validate($form_rules)) {
                return redirect()->back()->withInput()->with('msgDanger', '<strong>Failed</strong><br>' . $this->validator->listErrors());
            } else {
                $msg = "Successfuly Generated.";
                $data_response = [
                    'game'          => $game,
                    'user_key'      => $ukey,
                    'duration'      => $drtn,
                    'max_devices'   => $maxd,
                    'key_level'     => $levl,
                    'devices'       => md5($ukey),
                    'registrator'   => $user->username,
                ];

                $idKeys = $this->model->insert($data_response);
                $this->userModel->update(session('userid'), ['saldo' => $reduceCheck]);

                $history = new HistoryModel();
                $history->insertHistory([
                    'keys_id' => $idKeys,
                    'user_do' => $user->username,
                    'info' => "$game|" . substr($ukey ?: '', 0, 5) . "|$drtn|$maxd"
                ]);

                session()->setFlashdata(array_merge($data_response, ['fees' => $getPrice]));
                return redirect()->back()->with('msgSuccess', $msg);
            }
        }
    }
    
    private function get_shortened_link($url) {
        $api_token = '0ddecd1a5f75a4492866d0e55595f5467785468b';
        $long_url = urlencode($url);
        try {
            $response = file_get_contents("https://linkbulks.com/api?api={$api_token}&url={$long_url}");
            if ($response !== false) {
                return json_decode($response, true);
            }
        } catch (Exception $e) {
            return null;
        }
        return null;
    }

    private function create_user_key()
    {
        $ip_address = $this->request->getIPAddress();
        $hash = md5($ip_address . '-' . date('Y-m-d'));
        return substr(strtoupper(base_convert($hash, 16, 36)), 0, 16);
    }

    private function create_key() {
        $license = $this->create_user_key();
        $existing = $this->model->where('user_key', $license)->first();

        if ($existing) {
            return $license;
        }

        $duration = 1;
        $data_response = [
            'game'              => 'ALL',
            'user_key'          => $license,
            'duration'          => $duration,
            'max_devices'       => 1,
            'devices'           => md5($license),
            'key_level'         => 1,
            'registrator'       => 'freekey',
            'logins_remaining'  => -1,
            'status'            => 0,
            'expired_date'      => Time::now()->addHours(3)
        ];

        // $this->model->insert($data_response);
        return $license;
    }

    public function free()
    {
        if ($this->request->getMethod() == "post") {
            $crckey = crc32($this->create_key());
            $shortend_data = $this->get_shortened_link("https://zygame.click/keys/free/recreate?userkey=" . $crckey);
            return redirect()->to($shortend_data["shortenedUrl"]);
        } else {
            return view('Keys/free', ['link_total' => 1]);
        }
    }

    public function free_action()
    {
        $crckey = $this->request->getGet('userkey');
        $realkey = $this->create_user_key();
        $db_key = $this->model->getKeys($realkey);

        if ($db_key && $crckey)
        {
            $userkey = $db_key->user_key;

            $created = Time::parse($db_key->created_at, 'Asia/Jakarta');
            $now = Time::now('Asia/Jakarta');

            $diffInSeconds = $now->getTimestamp() - $created->getTimestamp();

            if ($created->isBefore($now->subSeconds(50)) && $created->isAfter($now->subMinutes(15)) && $crckey == crc32($userkey))
            {
                if ($db_key->logins_remaining == -1 && $db_key->game == 'ALL')
                {
                    $history = new HistoryModel();
                    $history->insertHistory([
                        'keys_id' => $db_key->id_keys,
                        'user_do' => $db_key->registrator,
                        'info' => "$db_key->game|" . substr($userkey, 0, 5) . "|$db_key->duration|$db_key->max_devices"
                    ]);

                    $this->model->update($db_key->id_keys, ['logins_remaining' => 1, 'status' => 1]);
                    return redirect()->to('keys/free')->with('msgSuccess', "Your key has been generated: " . $userkey);
                }
            }

            $this->model->where('user_key', $realkey)->delete();
        }

        return redirect()->to('keys/free')->with('msgDanger', 'There may be an error, please try again.');
    }
}