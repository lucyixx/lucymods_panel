<?php

namespace App\Controllers;

use App\Models\CodeModel;
use App\Models\HistoryModel;
use App\Models\ServerModel;
use App\Models\UserModel;
use CodeIgniter\Config\Services;

class User extends BaseController
{
    protected $model, $userid, $user, $time;

    public function __construct()
    {
        $this->userid = session()->userid;
        $this->model = new UserModel();
        $this->user = $this->model->getUser($this->userid);
        $this->time = new \CodeIgniter\I18n\Time;
    }

    public function index()
    {
        $historyModel = new HistoryModel();
        $data = [
            'title' => 'Dashboard',
            'user' => $this->user,
            'time' => $this->time,
            'history' => $historyModel->getAll(),
        ];
        return view('User/dashboard', $data);
    }

    public function ref_index()
    {
        $user  = $this->user;
        if ($user->level != 1)
            return redirect()->to('dashboard')->with('msgWarning', 'Access Denied!');

        if ($this->request->getPost())
            return $this->reff_action();

        $mCode = new CodeModel();
        $validation = Services::validation();
        $data = [
            'title' => 'Referral',
            'user' => $user,
            'time' => $this->time,
            'code' => $mCode->getCode(),
            'total_code' => $mCode->countAllResults(),
            'validation' => $validation
        ];
        return view('Admin/referral', $data);
    }

    private function reff_action()
    {
        $saldo = $this->request->getPost('saldo');
        $level = $this->request->getPost('level');
        $form_rules = [
            'saldo' => [
                'label' => 'saldo',
                'rules' => 'required|numeric|max_length[11]|greater_than_equal_to[0]',
                'errors' => [
                    'greater_than_equal_to' => 'Invalid currency, cannot set to minus.'
                ]
            ],
            'level' => [
                'label' => 'level',
                'rules' => 'required|numeric|max_length[11]|greater_than_equal_to[0]',
                'errors' => [
                    'greater_than_equal_to' => 'Invalid currency, cannot set to minus.'
                ]
            ]
        ];

        if (!$this->validate($form_rules)) {
            return redirect()->back()->withInput()->with('msgDanger', '<strong>Failed</strong><br>' . $this->validator->listErrors());
        } else {
            $code = random_string('alnum', 6);
            $codeHash = create_password($code, false);
            $referral_code = [
                'code' => $code,
                'hashed' => $codeHash,
                'saldo' => ($saldo < 1 ? 0 : $saldo),
                'level' => $level,
                'created_by' => session('unames')
            ];
            $ids = (new CodeModel())->insert($referral_code, true);
            if ($ids) {
                return redirect()->back()->with('msgSuccess', "<strong>Referral: </strong> $code");
            }
        }
    }

    public function api_get_users()
    {
        return $this->model->API_getUser();
    }

    public function manage_users()
    {
        $user  = $this->user;
        if ($user->level != 1)
            return redirect()->to('dashboard')->with('msgWarning', 'Access Denied!');

        $validation = Services::validation();
        $data = [
            'title' => 'Users',
            'user' => $user,
            'user_list' => $this->model->findAll(), //$model->getUserList(),
            'time' => $this->time,
            'validation' => $validation
        ];
        return view('Admin/users', $data);
    }

    public function singleDelete($id)
    {
        if ($id != 1) {
            $this->model->where('id_users', $id)->delete();
        }
        return redirect()->to('admin/manage-users')->with('msgSuccess', 'User has been deleted.');
    }

    public function user_edit($userid = false)
    {
        $user = $this->user;
        if ($user->level != 1)
            return redirect()->to('dashboard')->with('msgWarning', 'Access Denied!');

        if ($this->request->getPost())
            return $this->user_edit_action();

        $model = $this->model;
        $validation = Services::validation();

        $data = [
            'title' => 'Settings',
            'user' => $user,
            'target' => $model->getUser($userid),
            'user_list' => $model->getUserList(),
            'time' => $this->time,
            'validation' => $validation,
        ];
        return view('Admin/user_edit', $data);
    }

    private function user_edit_action()
    {
        $model = $this->model;
        $userid = $this->request->getPost('user_id');
        $username = $this->request->getPost('username');

        $target = $model->getUser($userid);
        if (!$target) {
            $msg = "User no longer exists.";
            return redirect()->to('dashboard')->with('msgDanger', $msg);
        }

        $form_rules = [
            'username' => [
                'label' => 'username',
                'rules' => "required|alpha_numeric|min_length[4]|max_length[25]|is_unique[users.username,username,$target->username]",
                'errors' => [
                    'is_unique' => 'The {field} has taken by other.'
                ]
            ],
            'fullname' => [
                'label' => 'name',
                'rules' => 'permit_empty|alpha_space|min_length[4]|max_length[155]',
                'errors' => [
                    'alpha_space' => 'The {field} only allow alphabetical characters and spaces.'
                ]
            ],
            'level' => [
                'label' => 'roles',
                'rules' => 'required|numeric|in_list[1,2]',
                'errors' => [
                    'in_list' => 'Invalid {field}.'
                ]
            ],
            'status' => [
                'label' => 'status',
                'rules' => 'required|numeric|in_list[0,1]',
                'errors' => [
                    'in_list' => 'Invalid {field} account.'
                ]
            ],
            'saldo' => [
                'label' => 'saldo',
                'rules' => 'permit_empty|numeric|max_length[11]|greater_than_equal_to[0]',
                'errors' => [
                    'greater_than_equal_to' => 'Invalid currency, cannot set to minus.'
                ]
            ],
            'uplink' => [
                'label' => 'uplink',
                'rules' => 'required|alpha_numeric|is_not_unique[users.username,username,]',
                'errors' => [
                    'is_not_unique' => 'Uplink not registered anymore.'
                ]
            ]
        ];

        if (!$this->validate($form_rules)) {
            return redirect()->back()->with('msgDanger', '<strong>Failed</strong><br>' . $this->validator->listErrors());
        } else {
            $fullname = $this->request->getPost('fullname');
            $level = $this->request->getPost('level');
            $status = $this->request->getPost('status');
            $saldo = $this->request->getPost('saldo');
            // $uplink = $this->request->getPost('uplink');

            $data_update = [
                'username' => $username,
                'fullname' => esc($fullname),
                'level' => $level,
                'status' => $status,
                'saldo' => (($saldo < 1) ? 0 : $saldo),
                // 'uplink' => $uplink,
            ];

            $update = $model->update($userid, $data_update);
            if ($update) {
                return redirect()->back()->with('msgSuccess', "Successfuly update $target->username.");
            }
        }
    }

    public function settings()
    {
        if ($this->request->getPost())
            return $this->settings_acton();

        $validation = Services::validation();
        $data = [
            'title' => 'Settings',
            'user' => $this->user,
            'time' => $this->time,
            'validation' => $validation
        ];

        return view('User/settings', $data);
    }

    private function settings_acton()
    { {
            $user = $this->user;
            $newName = $this->request->getPost('fullname');

            if ($user->fullname == $newName) {
                $validation = Services::validation();
                $msg = "Nothing to change.";
                $validation->setError('fullname', $msg);
            }

            $form_rules = [
                'fullname' => [
                    'label' => 'name',
                    'rules' => 'required|alpha_space|min_length[4]|max_length[155]',
                    'errors' => [
                        'alpha_space' => 'The {field} only allow alphabetical characters and spaces.'
                    ]
                ]
            ];

            if (!$this->validate($form_rules)) {
                return redirect()->back()->with('msgDanger', '<strong>Failed</strong><br>' . $this->validator->listErrors());
            } else {
                $this->model->update(session('userid'), ['fullname' => esc($newName)]);
            }
        } {
            $current = $this->request->getPost('current');
            $password = $this->request->getPost('password');

            $user = $this->user;
            $currHash = create_password($current, false);
            $validation = Services::validation();

            if (!password_verify($currHash, $user->password)) {
                $msg = "Wrong current password.";
                $validation->setError('current', $msg);
            } elseif ($current == $password) {
                $msg = "Nothing to change.";
                $validation->setError('password', $msg);
            }

            $form_rules = [
                'current' => [
                    'label' => 'current',
                    'rules' => 'required|min_length[6]|max_length[45]',
                ],
                'password' => [
                    'label' => 'password',
                    'rules' => 'required|min_length[6]|max_length[45]',
                ],
                'password2' => [
                    'label' => 'confirm',
                    'rules' => 'required|min_length[6]|max_length[45]|matches[password]',
                    'errors' => [
                        'matches' => '{field} not match, check the {field}.'
                    ]
                ],
            ];

            if (!$this->validate($form_rules)) {
                return redirect()->back()->withInput()->with('msgDanger', 'Something wrong! Please check the form');
            } else {
                $newPassword = create_password($current);
                $this->model->update(session('userid'), ['password' => $newPassword]);
            }
        }

        return redirect()->back()->with('msgSuccess', 'Settings Successfuly Changed.');
    }

    public function Server()
    {
        if ($this->user->level == 1) {
            if ($this->request->getPost())
                return $this->server_action();
        }

        if ($this->user->level == 1) {
            $data = [
                'title' => 'Server',
                'user' => $this->user,
                'time' => $this->time,
                'row' => (new ServerModel())->getRow(),
                'validation' => Services::validation()
            ];
            return view('Server/Server', $data);
        } else {
            return redirect()->to('dashboard')->with('msgWarning', 'Access Deniend');
        }
    }

    private function server_action()
    {
        $modname = $this->request->getPost('modname');
        $myinput = $this->request->getPost('myInput');
        $status = $this->request->getPost('radios');
        $data = [
            'modname' => $modname,
            'myinput' => $myinput,
            'status' => $status == '1' ? 'on' : 'off'
        ];
        (new ServerModel())->updateData($data);
        return redirect()->back()->with('msgSuccess', 'Server  Successfuly Changed.');
    }
}
