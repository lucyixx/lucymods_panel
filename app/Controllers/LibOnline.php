<?php

namespace App\Controllers;

use App\Models\FileModel;
use App\Models\UserModel;

class LibOnline extends BaseController
{
    protected $userid, $model, $user;
    protected $uploadPath = WRITEPATH . 'uploads';
    protected $hidden_extensions = ['php', 'html'];

    public function __construct()
    {
        $this->userid = session()->userid;
        $this->model = new FileModel();
        $this->user = (new UserModel())->getUser($this->userid);
    }

    public function index()
    {
        return $this->defaultPage();
    }

    public function getLibrariesJSON()
    {
        $directory = $this->uploadPath;
        if (!is_dir($directory)) {
            mkdir($directory);
        }

        if (is_dir($directory)) {
            $result = $this->getDirectoryListing($directory);
        } else {
            return $this->Error("Not a Directory");
        }

        return json_encode(['success' => true, 'is_writable' => is_writable($directory), 'results' => $result]);
    }

    public function delete($file)
    {
        $file = base64_decode($file);
        if (file_exists($file)) {
            if (unlink($file)) {
                $name = basename($file);
                $this->model->where('name', $name)->delete();
                return $this->Success('File <strong>' . $name . '</strong> deleted successfully.');
            } else {
                return $this->Error('Failed to delete the file.');
            }
        } else {
            return $this->Error('File not found.');
        }
    }

    public function download($file)
    {
        $file = base64_decode($file);
        if (file_exists($file)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Content-Length: ' . filesize($file));

            readfile($file);
        } else {
            return $this->Error('File not found.');
        }
    }

    public function upload()
    {

        $rules = [
            'file' => [
                'label' => 'Library File',
                'rules' => [
                    'uploaded[file]',
                    'mime_in[file,application/x-sharedlib]',
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->Error('<strong>Failed</strong><br>' . $this->validator->listErrors());
        }

        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            $file->move($this->uploadPath);

            $this->model->insert([
                'name' =>  $file->getName(),
                'type'  => $file->getClientMimeType(),
                'status' => true,
            ]);

            return $this->Success('File uploaded successfully.');
        } else {
            return $this->Error('File upload failed.');
        }
    }

    public function defaultPage()
    {
        $data = [
            'title' => 'Libraries Manager',
            'user' => $this->user,
            'uploadPath' => $this->uploadPath,
            'files' => $this->getDirectoryListing($this->uploadPath),
        ];

        return view('Server/libonline', $data);
    }

    private function getFilePermissionName($filePath)
    {
        $filePermissions = fileperms($filePath);
        $binaryPermissions = sprintf('%o', $filePermissions & 0777);
        $permissionMap = [
            '---',
            '--x',
            '-w-',
            '-wx',
            'r--',
            'r-x',
            'rw-',
            'rwx',
        ];

        $permissionName = '';
        for ($i = 0; $i < strlen($binaryPermissions); $i++) {
            $digit = substr($binaryPermissions, $i, 1);
            $permissionName .= $permissionMap[$digit];
        }

        return $permissionName;
    }

    private function getDirectoryListing($directory)
    {
        $result = [];
        $files = array_diff(scandir($directory), ['.', '..']);
        foreach ($files as $entry) {
            if (!$this->isEntryIgnored($entry, true, $this->hidden_extensions)) {
                $i = $directory . '/' . $entry;

                $mime_type = mime_content_type($i);

                if ($mime_type === 'application/x-sharedlib') { // check if shared lib file
                    $stat = stat($i);

                    $result[] = [
                        'mtime' => $stat['mtime'],
                        'size' => $stat['size'],
                        'name' => basename($i),
                        'path' => preg_replace('@^\./@', '', $i),
                        'is_dir' => is_dir($i),
                        'is_deleteable' => ((!is_dir($i) && is_writable($directory)) || (is_dir($i) && is_writable($directory) && $this->isRecursivelyDeleteable($i))),
                        'is_readable' => is_readable($i),
                        'is_writable' => is_writable($i),
                        'is_executable' => is_executable($i),
                        'permissions' => $this->getFilePermissionName($i),
                    ];
                }
            }
        }
        usort($result, function ($f1, $f2) {
            $f1_key = ($f1['is_dir'] ?: 2) . $f1['name'];
            $f2_key = ($f2['is_dir'] ?: 2) . $f2['name'];
            return $f1_key > $f2_key;
        });
        return $result;
    }

    private function isEntryIgnored($entry, $allow_show_folders, $hidden_extensions)
    {
        if ($entry === basename(__FILE__)) {
            return true;
        }

        if (is_dir($entry) && !$allow_show_folders) {
            return true;
        }

        $ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
        if (in_array($ext, $hidden_extensions)) {
            return true;
        }

        return false;
    }

    public function rmrf($dir)
    {
        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $this->rmrf("$dir/$file");
            }
            return rmdir($dir);
        } else {
            return unlink($dir);
        }
        return false;
    }

    private function isRecursivelyDeleteable($d)
    {
        $stack = [$d];
        while ($dir = array_pop($stack)) {
            if (!is_readable($dir) || !is_writable($dir)) {
                return false;
            }
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    $stack[] = "$dir/$file";
                }
            }
        }
        return true;
    }

    public function asBytes($ini_v)
    {
        $ini_v = trim($ini_v);
        $s = ['g' => 1 << 30, 'm' => 1 << 20, 'k' => 1 << 10];
        return intval($ini_v) * ($s[strtolower(substr($ini_v, -1))] ?: 1);
    }

    public function get_absolute_path($path)
    {
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        $parts = explode(DIRECTORY_SEPARATOR, $path);
        $absolutes = [];
        foreach ($parts as $part) {
            if ('.' == $part) {
                continue;
            }
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }

    public function Success($msg)
    {
        return redirect()->to("libOnline")->with('msgSuccess', $msg);
    }

    public function Error($msg)
    {
        return redirect()->to("libOnline")->with('msgDanger', $msg);
    }
}
