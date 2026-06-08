<?= $this->extend('Layout/template'); ?>
<?= $this->section('content'); ?>

<?php
    $booksCount = count($books ?? []);
    $reviewsCount = count($reviews ?? []);
?>

<section class="page-hero">
    <div class="container">
        <div class="hero-panel">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="hero-kicker mb-3">
                        <i class="bi bi-person-badge"></i>
                        Detail autora
                    </span>
                    <h1><?= esc($author['name'] ?? 'Neznámý autor') ?></h1>
                    <p class="mt-3 mb-0">
                        <?= esc($author['name'] ?? 'Autor') ?> a jeho knihy receptů, hodnocení a recenze na jednom místě.
                    </p>
                </div>

                <div class="col-lg-4">
                    <div class="bg-white border rounded-4 p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <div class="text-uppercase text-secondary small fw-semibold">Knihy receptů</div>
                                <div class="fs-4 fw-bold"><?= $booksCount ?></div>
                            </div>
                            <i class="bi bi-journals fs-1 text-warning"></i>
                        </div>
                        <div class="small text-secondary">Recenze k autorovým knihám: <?= $reviewsCount ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-4">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Domů</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('autori') ?>">Autoři</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($author['name'] ?? 'Detail autora') ?></li>
            </ol>
        </nav>

        <div class="hero-panel mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="bg-white border rounded-4 p-3 h-100">
                        <div class="text-secondary small text-uppercase fw-semibold">Jméno autora</div>
                        <div class="fw-semibold fs-5"><?= esc($author['name'] ?? '—') ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white border rounded-4 p-3 h-100">
                        <div class="text-secondary small text-uppercase fw-semibold">Datum narození</div>
                        <div class="fw-semibold fs-5"><?= esc($author['birth_date'] ?? '—') ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white border rounded-4 p-3 h-100">
                        <div class="text-secondary small text-uppercase fw-semibold">Národnost</div>
                        <div class="fw-semibold fs-5"><?= esc($author['nationality'] ?? '—') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="section-title mb-3">Všechny knihy receptů</h2>

        <?php if (!empty($books)): ?>
            <div class="row books-grid mb-5">
                <?php foreach ($books as $index => $book): ?>
                    <?php
                        $rating = $book['avg_rating'] !== null ? number_format((float) $book['avg_rating'], 1, ',', ' ') : 'N/A';
                        $imagePath = !empty($book['cover_image']) ? base_url('uploads/' . $book['cover_image']) : null;
                        $delayClass = 'fade-delay-' . ((($index % 4) + 1));
                    ?>
                    <div class="col-sm-6 col-lg-3">
                        <a class="book-card <?= $delayClass ?>" href="<?= base_url('recept/detail/' . ($book['idBooks'] ?? 0) . '/' . ($book['slug'] ?? 'kniha')) ?>">
                            <div class="cover-wrap">
                                <?php if ($imagePath): ?>
                                    <img src="<?= esc($imagePath) ?>" alt="<?= esc($book['title'] ?? 'Kniha') ?>">
                                <?php else: ?>
                                    <div class="cover-fallback">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="badge-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <?= esc($rating) ?>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="card-meta">
                                    <span class="pill"><i class="bi bi-chat-dots"></i> <?= esc((string) ($book['review_count'] ?? 0)) ?> recenzí</span>
                                </div>
                                <div class="card-genre"><?= esc($book['genre_name'] ?? 'Žánr') ?></div>
                                <h3 class="card-title"><?= esc($book['title'] ?? 'Bez názvu') ?></h3>
                                <p class="card-desc mb-2"><?= esc($book['description'] ?? 'Popis zatím není k dispozici.') ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state mb-5">Tento autor zatím nemá přiřazené žádné knihy receptů.</div>
        <?php endif; ?>

        <h2 class="section-title mb-3">Recenze k jeho knihám</h2>

        <?php if (!empty($reviews)): ?>
            <div class="vstack gap-3">
                <?php foreach ($reviews as $review): ?>
                    <article class="bg-white border rounded-4 p-3 p-md-4">
                        <div class="d-flex justify-content-between gap-3 flex-wrap mb-2">
                            <strong><?= esc($review['username'] ?? 'Anonymní uživatel') ?></strong>
                            <span class="pill"><i class="bi bi-star-fill text-warning"></i> <?= esc((string) $review['rating']) ?></span>
                        </div>
                        <div class="small text-secondary mb-2">Kniha: <?= esc($review['book_title'] ?? '—') ?></div>
                        <p class="mb-2 text-secondary"><?= esc($review['review_text'] ?? '') ?></p>
                        <div class="small text-secondary"><?= esc($review['created_at'] ?? '') ?></div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">K tomuto autorovi zatím nejsou žádné recenze.</div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection(); ?>