<?php

namespace App\Repositories;

use App\Models\Backup;

class BackupRepository
{
    public function getAll()
    {
        return Backup::with('user')->latest()->get();
    }

    public function find($id)
    {
        return Backup::findOrFail($id);
    }

    public function create(array $data)
    {
        return Backup::create($data);
    }

    public function delete($id)
    {
        $backup = $this->find($id);
        $backup->delete();
        return $backup;
    }
}
