<nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top">
	<div class="container py-2">
		<a class="navbar-brand fw-bold display-font" href="<?= base_url('/') ?>">Knihovna</a>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Přepnout navigaci">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="mainNavbar">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-1">
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="<?= base_url('/') ?>">Domů</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= base_url('autori') ?>">Stránka 1</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Stránka 2</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Stránka 3</a>
				</li>
			</ul>

			<div class="d-flex align-items-lg-center ms-lg-auto">
				<a class="btn btn-login" href="#">Přihlášení</a>
			</div>
		</div>
	</div>
</nav>
