<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuthorModel;
use App\Models\BookModel;
use App\Models\GenreModel;
use CodeIgniter\HTTP\ResponseInterface;

class Main extends BaseController
{
    /**
     * Homepage – náhodný výpis knih s filtrem hodnocení.
     */
    public function index(): string
    {
        $bookModel  = new BookModel();
        $genreModel = new GenreModel();
        helper('slug');
 
        // Filtr hodnocení z GET parametru (1–5 nebo null)
        $ratingBucket = $this->request->getGet('rating');
        $ratingBucket = ($ratingBucket !== null && $ratingBucket !== '')
            ? (int) $ratingBucket
            : null;

        $prepTime = $this->request->getGet('time') ?? '';
 
        $perPage = config('App')->perPage ?? 12;

        $books = $bookModel->getHomepageBooks($ratingBucket, $perPage);

        foreach ($books as &$book) {
            $book['slug'] = slugify_text($book['title'] ?? 'kniha');
            $book['avg_rating'] = isset($book['avg_rating']) && $book['avg_rating'] !== null
                ? (float) $book['avg_rating']
                : null;
            $book['review_count'] = (int) ($book['review_count'] ?? 0);
        }
        unset($book);
 
        $data = [
            'books'      => $books,
            'genres'     => $genreModel->getAllGenres(),
            'ratingBucket' => $ratingBucket,
            'prepTime'   => $prepTime,
            'title'      => 'Domů',
        ];
 
        return view('index', $data);
    }

    /**
     * Detail receptu podle ID a slugu.
     */
    public function detail(int $id, ?string $slug = null): string|ResponseInterface
    {
        helper('slug');

        $bookModel = new BookModel();
        $book = $bookModel->getBookDetail($id);

        if ($book === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $book['slug'] = slugify_text($book['title'] ?? 'kniha');

        if ($slug !== null && $slug !== '' && $slug !== $book['slug']) {
            return redirect()->to(base_url('recept/detail/' . $id . '/' . $book['slug']));
        }

        $book['avg_rating'] = isset($book['avg_rating']) && $book['avg_rating'] !== null
            ? (float) $book['avg_rating']
            : null;
        $book['review_count'] = (int) ($book['review_count'] ?? 0);

        $db = db_connect();

        $reviews = $db->table('reviews r')
            ->select('r.idReviews, r.rating, r.review_text, r.created_at, u.username')
            ->join('users u', 'u.idUsers = r.Users_idUsers', 'left')
            ->where('r.Books_idBooks', $id)
            ->orderBy('r.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title'   => $book['title'] ?? 'Detail receptu',
            'book'    => $book,
            'reviews' => $reviews,
        ];

        return view('detail', $data);
    }

    /**
     * Výpis všech autorů se stránkováním.
     */
    public function authors(): string
    {
        $authorModel = new AuthorModel();
        $perPage = config('App')->perPage ?? 12;
        helper('slug');

        $authors = $authorModel->getPaginatedAuthors($perPage);

        foreach ($authors as &$author) {
            $author['slug'] = slugify_text($author['name'] ?? 'autor');
        }
        unset($author);

        $data = [
            'title'   => 'Autoři',
            'authors' => $authors,
            'pager'   => $authorModel->pager,
        ];

        return view('authors', $data);
    }

    /**
     * Detail autora včetně jeho knih receptů a recenzí.
     */
    public function authorDetail(int $id, ?string $slug = null): string|ResponseInterface
    {
        helper('slug');

        $authorModel = new AuthorModel();
        $author = $authorModel->getAuthorDetail($id);

        if ($author === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $author['slug'] = slugify_text($author['name'] ?? 'autor');

        if ($slug !== null && $slug !== '' && $slug !== $author['slug']) {
            return redirect()->to(base_url('autori/detail/' . $id . '/' . $author['slug']));
        }

        $db = db_connect();

        $books = $db->table('books b')
            ->select('b.idBooks, b.title, b.description, b.cover_image, g.name AS genre_name, ROUND(AVG(r.rating), 1) AS avg_rating, COUNT(r.idReviews) AS review_count')
            ->join('books_has_authors bha', 'bha.Books_idBooks = b.idBooks')
            ->join('genres_has_books ghb', 'ghb.Books_idBooks = b.idBooks')
            ->join('genres g', 'g.idGenres = ghb.Genres_idGenres')
            ->join('reviews r', 'r.Books_idBooks = b.idBooks', 'left')
            ->where('bha.Authors_idAuthors', $id)
            ->groupBy('b.idBooks, b.title, b.description, b.cover_image, g.name')
            ->orderBy('b.title', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($books as &$book) {
            $book['slug'] = slugify_text($book['title'] ?? 'kniha');
            $book['avg_rating'] = isset($book['avg_rating']) && $book['avg_rating'] !== null
                ? (float) $book['avg_rating']
                : null;
            $book['review_count'] = (int) ($book['review_count'] ?? 0);
        }
        unset($book);

        $reviews = $db->table('reviews r')
            ->select('r.idReviews, r.rating, r.review_text, r.created_at, u.username, b.title AS book_title')
            ->join('users u', 'u.idUsers = r.Users_idUsers', 'left')
            ->join('books b', 'b.idBooks = r.Books_idBooks', 'left')
            ->join('books_has_authors bha', 'bha.Books_idBooks = b.idBooks')
            ->where('bha.Authors_idAuthors', $id)
            ->orderBy('r.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title'   => $author['name'] ?? 'Detail autora',
            'author'  => $author,
            'books'   => $books,
            'reviews' => $reviews,
        ];

        return view('author_detail', $data);
    }
}
