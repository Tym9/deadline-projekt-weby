<?= $this->extend('Layout/template'); ?>
<?= $this->section('content'); ?>

<section class="page-hero">
    <div class="container">
        <div class="hero-panel">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="hero-kicker mb-3">
                        <i class="bi bi-people"></i>
                        Seznam autorů
                    </span>
                    <h1>Autoři receptů přehledně pod sebou.</h1>
                    <p class="mt-3 mb-0">
                        Stránka zobrazuje autory načítané z databáze a používá stránkování podle nastavení projektu.
                    </p>
                </div>

                <div class="col-lg-4">
                    <div class="bg-white border rounded-4 p-3 p-md-4">
                        <div class="text-uppercase text-secondary small fw-semibold mb-1">Na stránce</div>
                        <div class="fs-4 fw-bold"><?= count($authors ?? []) ?></div>
                        <div class="small text-secondary">autorů v aktuálním výpisu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-3">
            <div>
                <h2 class="section-title mb-1">Všichni autoři</h2>
                <p class="section-subtitle">Seřazeno abecedně podle jména.</p>
            </div>
        </div>

        <?php if (!empty($authors)): ?>
            <div class="vstack gap-3">
                <?php foreach ($authors as $author): ?>
                    <article class="bg-white border rounded-4 p-3 p-md-4 author-row">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center">
                            <div>
                                <h3 class="h5 mb-1">
                                    <a class="text-decoration-none text-dark" href="<?= base_url('autori/detail/' . ($author['idAuthors'] ?? 0) . '/' . ($author['slug'] ?? 'autor')) ?>">
                                        <?= esc($author['name'] ?? 'Neznámý autor') ?>
                                    </a>
                                </h3>
                                <div class="text-secondary small">
                                    <span class="me-3"><i class="bi bi-calendar-event me-1"></i><?= esc($author['birth_date'] ?? '—') ?></span>
                                    <span><i class="bi bi-globe2 me-1"></i><?= esc($author['nationality'] ?? '—') ?></span>
                                </div>
                            </div>
                            <div class="text-md-end small text-secondary">
                                <div class="fw-semibold text-dark">Detail autora</div>
                                <div>Kliknutím zobrazíte jeho kuchařky a recenze.</div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="mt-4">
                <?= $pager->links() ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-people fs-1 d-block mb-2"></i>
                <div class="fw-semibold mb-1">Zatím nejsou k dispozici žádní autoři.</div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection(); ?>