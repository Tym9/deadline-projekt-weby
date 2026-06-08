<?= $this->extend('Layout/template'); ?>
<?= $this->section('content'); ?>

<section class="page-hero">
	<div class="container">
		<div class="hero-panel">
			<div class="row align-items-center g-4">
				<div class="col-lg-8">
					<span class="hero-kicker mb-3">
						<i class="bi bi-book-half"></i>
						Knihy receptů z databáze
					</span>
					<h1>Inspirace v podobě kuchařek, autorů a hodnocení na jednom místě.</h1>
					<p class="mt-3 mb-0">
						Úvodní stránka načítá knihy receptů náhodně z databáze, zobrazuje průměrné hodnocení, autora i žánr a připravuje strukturu pro detail knihy, seznam autorů i přihlášení.
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="pb-4">
	<div class="container">
		<form class="filter-bar mb-4" method="get" action="<?= current_url() ?>">
			<div class="row g-3 align-items-end">
				<div class="col-lg-4">
					<label for="rating-filter" class="form-label fw-semibold">Filtr podle hodnocení</label>
					<select class="form-select" id="rating-filter" name="rating">
						<option value="" <?= $ratingBucket === null ? 'selected' : '' ?>>Vyberte rozmezí hodnocení</option>
						<option value="1" <?= $ratingBucket === 1 ? 'selected' : '' ?>>1 - 2</option>
						<option value="2" <?= $ratingBucket === 2 ? 'selected' : '' ?>>2 - 3</option>
						<option value="3" <?= $ratingBucket === 3 ? 'selected' : '' ?>>3 - 4</option>
						<option value="4" <?= $ratingBucket === 4 ? 'selected' : '' ?>>4 - 5</option>
					</select>
				</div>

				<div class="col-lg-4 hero-cta d-flex gap-2 justify-content-lg-end">
					<button type="submit" class="btn btn-filter">
						<i class="bi bi-funnel me-1"></i>Filtrovat
					</button>
					<a href="<?= base_url('/') ?>" class="btn btn-reset">
						<i class="bi bi-arrow-counterclockwise me-1"></i>Reset
					</a>
				</div>
			</div>
		</form>
	</div>
</section>

<section class="pb-5">
	<div class="container">
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-3">
			<div>
				<h2 class="section-title mb-1">Náhodně vybrané knihy receptů</h2>
				<p class="section-subtitle">Každá karta ukazuje průměrné hodnocení, autora a žánr.</p>
			</div>
			<div class="text-secondary small">
				<?= count($books ?? []) ?> položek na stránce
			</div>
		</div>

		<?php if (!empty($books)): ?>
			<div class="row books-grid">
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
									<img src="<?= esc($imagePath) ?>" alt="<?= esc($book['title'] ?? 'Recept') ?>">
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
								<div class="card-author">
									<i class="bi bi-person"></i>
									<span><?= esc($book['author_name'] ?? 'Neznámý autor') ?></span>
								</div>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<div class="empty-state">
				<i class="bi bi-inbox fs-1 d-block mb-2"></i>
				<div class="fw-semibold mb-1">Zatím nejsou k dispozici žádné recepty.</div>
				<div>Jakmile budou data v databázi, zobrazí se zde náhodně načtené karty receptů.</div>
			</div>
		<?php endif; ?>
	</div>
</section>

<?= $this->endSection(); ?>