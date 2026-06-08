<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    // ------------------------------------------------------------------
    //  Základní SELECT se všemi JOINy (books + authors + genres + AVG)
    // ------------------------------------------------------------------

    /**
     * Vrátí builder s připravenými JOINy pro výpis knih.
     * Používá se jako základ pro filtrování i stránkování.
     *
     * @return \CodeIgniter\Database\BaseBuilder
     */
    private function baseQuery()
    {
        return $this->db->table('books b')
            ->select('
                b.idBooks,
                b.title,
                b.description,
                b.cover_image,
                b.publication_date,
                b.language,
                b.page_count,
                a.idAuthors,
                a.name       AS author_name,
                g.idGenres,
                g.name       AS genre_name,
                ROUND(AVG(r.rating), 1) AS avg_rating,
                COUNT(r.idReviews)      AS review_count
            ')
            ->join('books_has_authors bha', 'bha.Books_idBooks  = b.idBooks', 'left')
            ->join('authors a', 'a.idAuthors        = bha.Authors_idAuthors AND a.deleted_at IS NULL', 'left')
            ->join('genres_has_books ghb', 'ghb.Books_idBooks  = b.idBooks', 'left')
            ->join('genres g', 'g.idGenres         = ghb.Genres_idGenres', 'left')
            ->join('reviews r', 'r.Books_idBooks    = b.idBooks', 'left')
            ->where('b.deleted_at IS NULL')
            ->groupBy('b.idBooks, b.title, b.description, b.cover_image,
                       b.publication_date, b.language, b.page_count,
                       a.idAuthors, a.name, g.idGenres, g.name');
    }

    // ------------------------------------------------------------------
    //  Homepage – náhodný výpis s volitelnými filtry
    // ------------------------------------------------------------------

    /**
     * Vrátí náhodně seřazené knihy pro homepage.
     * Volitelně filtruje podle rozsahu hodnocení.
     *
     * @param int|null   $ratingBucket  Hodnotový bucket (1–5), nebo null
     * @param int        $limit      Počet knih na stránku (z config)
     * @return array
     */
    public function getHomepageBooks(?int $ratingBucket = null, int $limit = 12): array
    {
        $builder = $this->baseQuery()->orderBy('RAND()')->limit($limit);

        if ($ratingBucket !== null) {
            $ratingBucket = max(1, min(5, $ratingBucket));

            $builder->having('avg_rating >=', $ratingBucket);

            if ($ratingBucket < 5) {
                $builder->having('avg_rating <', $ratingBucket + 1);
            }
        }

        return $builder->get()->getResultArray();
    }

    // ------------------------------------------------------------------
    //  Stránka Recepty – vyhledávání + filtr hodnocení + stránkování
    // ------------------------------------------------------------------

    /**
     * Vrátí filtrovaný seznam knih pro stránku Recepty.
     *
     * @param array $filters  Asociativní pole: ['search' => '', 'min_rating' => null, 'genre' => null]
     * @param int   $limit    Počet položek na stránku
     * @param int   $offset   Offset pro stránkování
     * @return array
     */
    public function getFilteredBooks(array $filters = [], int $limit = 12, int $offset = 0): array
    {
        $builder = $this->baseQuery();

        if (!empty($filters['search'])) {
            $search = $this->db->escapeLikeString($filters['search']);
            $builder->groupStart()
                ->like('b.title', $search)
                ->orLike('b.description', $search)
                ->orLike('a.name', $search)
                ->groupEnd();
        }

        if (!empty($filters['genre'])) {
            $builder->where('g.idGenres', (int) $filters['genre']);
        }

        if (!empty($filters['min_rating'])) {
            $builder->having('avg_rating >=', (int) $filters['min_rating']);
        }

        return $builder->orderBy('b.title', 'ASC')->limit($limit, $offset)->get()->getResultArray();
    }

    /**
     * Vrátí celkový počet knih pro stránkování (se stejnými filtry).
     *
     * @param array $filters
     * @return int
     */
    public function countFilteredBooks(array $filters = []): int
    {
        $builder = $this->db->table('books b')
            ->select('b.idBooks')
            ->join('books_has_authors bha', 'bha.Books_idBooks  = b.idBooks', 'left')
            ->join('authors a', 'a.idAuthors        = bha.Authors_idAuthors AND a.deleted_at IS NULL', 'left')
            ->join('genres_has_books ghb', 'ghb.Books_idBooks  = b.idBooks', 'left')
            ->join('genres g', 'g.idGenres         = ghb.Genres_idGenres', 'left')
            ->join('reviews r', 'r.Books_idBooks    = b.idBooks', 'left')
            ->where('b.deleted_at IS NULL')
            ->groupBy('b.idBooks');

        if (!empty($filters['search'])) {
            $search = $this->db->escapeLikeString($filters['search']);
            $builder->groupStart()
                ->like('b.title', $search)
                ->orLike('b.description', $search)
                ->orLike('a.name', $search)
                ->groupEnd();
        }

        if (!empty($filters['genre'])) {
            $builder->where('g.idGenres', (int) $filters['genre']);
        }

        return $this->db->query(
            'SELECT COUNT(*) AS total FROM (' . $builder->getCompiledSelect() . ') sub'
        )->getRow()->total ?? 0;
    }

    // ------------------------------------------------------------------
    //  Detail knihy
    // ------------------------------------------------------------------

    /**
     * Vrátí detail jedné knihy podle ID včetně autora, žánru a průměrného hodnocení.
     *
     * @param int $id  ID knihy (idBooks)
     * @return array|null
     */
    public function getBookDetail(int $id): ?array
    {
        $result = $this->baseQuery()
            ->where('b.idBooks', $id)
            ->get()
            ->getRowArray();

        return $result ?: null;
    }
}
