<?php

namespace App\Models;

use CodeIgniter\Model;

class CategorieModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'slug'];

    public function toutes()
    {
        return $this->orderBy('nom', 'ASC')->findAll();
    }
}