<?php
namespace App\Models;

use CodeIgniter\Model;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\I18n\Time;

class KeysModel extends Model
{
    protected $table      = 'keys_code';
    protected $primaryKey = 'id_keys';
    protected $allowedFields = ['game', 'user_key', 'key_level', 'duration', 'expired_date', 'max_devices', 'devices', 'logins_remaining', 'status', 'registrator'];

    public function getKeys($key = false, $where = 'user_key')
    {
        if (!in_array($where, $this->allowedFields) && $where !== $this->primaryKey) {
            throw new \InvalidArgumentException("Invalid field: {$where}");
        }
        
        return $this->where($where, $key)
            ->get()
            ->getRowObject();
    }

    public function getKeysGame(array $where)
    {
        $filtered = array_intersect_key($where, array_flip($this->allowedFields));
        
        if (empty($filtered)) {
            throw new \InvalidArgumentException('No valid conditions provided');
        }
        
        return $this->where($filtered)
            ->get()
            ->getRowObject();
    }
    
    public function API_getKeys()
    {
        $connect = db_connect();
        $builder = $connect->table($this->table);

        $userModel = new UserModel();
        $user = $userModel->getUser();
        if ($user->level != 1) {
            $builder->where('registrator', $user->username);
        }

        $builder = $builder->select('CONCAT(keys_code.id_keys) as id, game, user_key, key_level, duration, CONCAT(keys_code.expired_date) as expired, max_devices, devices, status, registrator');

        return DataTable::of($builder)
            ->setSearchableColumns(['id_keys', 'game', 'user_key', 'key_level', 'duration', 'expired_date', 'max_devices', 'devices', 'status', 'registrator'])
            ->format('status', function ($value) {
                return ($value ? "Active" : "Inactive");
            })
            ->format('duration', function ($value) {
                return "$value Days";
            })
            ->format('devices', function ($value) {
                if ($value) {
                    $e = explode(',', reduce_multiples($value, ",", true));
                }
                return $value ? count($e) : 0;
            })
            ->format('expired_date', function ($value) {
                return $value ? Time::parse($value)->toLocalizedString('yyyy-MM-ddTHH:mm:ss') : '';
                // return $value ? Time::parse($value)->toLocalizedString('d MMM yy - H:m') : '';
            })
            ->toJson(true);
    }
    
    
}
