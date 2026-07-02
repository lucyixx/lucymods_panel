<?php

// app/Models/FileModel.php

namespace App\Models;

use CodeIgniter\Model;

class FileModel extends Model
{
    protected $table = 'libonline'; // Replace with your database table name
    protected $primaryKey = 'id'; // Replace with the primary key field name if it's different
    protected $allowedFields = ['name', 'type', 'status'];
}
