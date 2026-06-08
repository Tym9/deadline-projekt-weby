<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthorModel extends Model
{
    protected $table = 'authors';
    protected $primaryKey = 'idAuthors';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Vrátí autory seřazené podle jména pro stránkování.
     *
     * @param int $perPage Počet záznamů na stránku
     * @return array
     */
    public function getPaginatedAuthors(int $perPage = 12): array
    {
        return $this->select('idAuthors, name, birth_date, nationality')
            ->orderBy('name', 'ASC')
            ->paginate($perPage);
    }

    /**
     * Vrátí detail autora podle ID.
     *
     * @param int $authorId ID autora
     * @return array|null
     */
    public function getAuthorDetail(int $authorId): ?array
    {
        $author = $this->select('idAuthors, name, birth_date, nationality')
            ->where('idAuthors', $authorId)
            ->first();

        return $author ?: null;
    }
}