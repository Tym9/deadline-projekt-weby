<?= $this->extend('Layout/template'); ?>
<?= $this->section('content'); ?>

<?php
    $imagePath = !empty($book['cover_image']) ? base_url('uploads/' . $book['cover_image']) : null;
    $rating = $book['avg_rating'] !== null ? number_format((float) $book['avg_rating'], 1, ',', ' ') : 'N/A';
?>

<section class="py-4 py-lg-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Domů</a></li>
                <li class="breadcrumb-item"><a href="#">Recepty</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($book['title'] ?? 'Detail receptu') ?></li>
            </ol>
        </nav>

        <div class="row g-4 align-items-start">
            <div class="col-lg-4">
                <div class="hero-panel p-3 p-md-4">
                    <div class="cover-wrap rounded-4 overflow-hidden mb-3" style="aspect-ratio: 3 / 4;">
                        <?php if ($imagePath): ?>
                            <img class="w-100 h-100 object-fit-cover" src="<?= esc($imagePath) ?>" alt="<?= esc($book['title'] ?? 'Recept') ?>">
                        <?php else: ?>
                            <div class="cover-fallback h-100">
                                <i class="bi bi-journal-text"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <span class="pill"><i class="bi bi-star-fill text-warning"></i> <?= esc($rating) ?></span>
                        <span class="pill"><i class="bi bi-chat-dots"></i> <?= esc((string) $book['review_count']) ?> recenzí</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="hero-panel">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="hero-kicker"><i class="bi bi-person"></i> <?= esc($book['author_name'] ?? 'Neznámý autor') ?></span>
                        <span class="hero-kicker"><i class="bi bi-tag"></i> <?= esc($book['genre_name'] ?? 'Žánr') ?></span>
                    </div>

                    <h1 class="mb-3"><?= esc($book['title'] ?? 'Bez názvu') ?></h1>
                    <p class="lead mb-4"><?= esc($book['description'] ?? 'Popis zatím není k dispozici.') ?></p>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-xl-4">
                            <div class="bg-white border rounded-4 p-3 h-100">
                                <div class="text-secondary small text-uppercase fw-semibold">Autor</div>
                                <div class="fw-semibold"><?= esc($book['author_name'] ?? 'Neznámý autor') ?></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-4">
                            <div class="bg-white border rounded-4 p-3 h-100">
                                <div class="text-secondary small text-uppercase fw-semibold">Žánr</div>
                                <div class="fw-semibold"><?= esc($book['genre_name'] ?? 'Žánr') ?></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-4">
                            <div class="bg-white border rounded-4 p-3 h-100">
                                <div class="text-secondary small text-uppercase fw-semibold">Průměrné hodnocení</div>
                                <div class="fw-semibold"><?= esc($rating) ?></div>
                            </div>
                        </div>
                    </div>

                    <h2 class="section-title mb-3">Všechny recenze</h2>

                    <?php if (!empty($reviews)): ?>
                        <div class="vstack gap-3">
                            <?php foreach ($reviews as $review): ?>
                                <article class="bg-white border rounded-4 p-3 p-md-4">
                                    <div class="d-flex justify-content-between gap-3 flex-wrap mb-2">
                                        <strong><?= esc($review['username'] ?? 'Anonymní uživatel') ?></strong>
                                        <span class="pill"><i class="bi bi-star-fill text-warning"></i> <?= esc((string) $review['rating']) ?></span>
                                    </div>
                                    <p class="mb-2 text-secondary"><?= esc($review['review_text'] ?? '') ?></p>
                                    <div class="small text-secondary"><?= esc($review['created_at'] ?? '') ?></div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">K tomuto receptu zatím nejsou žádné recenze.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>