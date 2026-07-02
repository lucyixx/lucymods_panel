<?php

namespace App\Models;

use CodeIgniter\Model;

class GameModel extends Model
{
    protected $table = 'games';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'package']; // Adjust fields as needed

    public function addIfNotExists($gameName, $packageName)
    {
        $existingGame = $this->where('package', $packageName)->first();
        if (!$existingGame) {
            $this->insert(['name' => $gameName, 'package' => $packageName]);
        }
    }

    public function getGames()
    {
        return $this->findAll();
    }

    public function getGameMap($default = []): array
    {
        $games = [];
        $games = array_merge($games, $default);
        $result = $this->findAll();
        foreach ($result as $row) {
            $games[$row['package']] = $row['name'];
        }
        return $games;
    }

    public function getGame($package) {
        return $this->where('package', $package)
            ->get()
            ->getRowObject();
    }
}
