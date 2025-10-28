<?php
session_start();

// If user is already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="nl" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streamflix - Unlimited Films en Series</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark position-fixed w-100 landing-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <svg width="40" height="40" viewBox="0 0 150 165" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" class="me-2">
                <defs>
                    <linearGradient id="gIcon-navbar" x1="12" y1="12" x2="132" y2="132" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#FF2E63"/>
                        <stop offset="0.5" stop-color="#FF5F32"/>
                        <stop offset="1" stop-color="#FF8A00"/>
                    </linearGradient>
                </defs>
                <path d="M118 54c0-24.3-18.7-42-42-42H66.5c-9.6 0-17.5 7.9-17.5 17.5S56.9 47 66.5 47H76c8.3 0 15 6.7 15 15 0 6-3.6 11.5-9.2 13.8L53.4 89.4C38.2 95.8 30 107.9 30 123c0 24.3 18.7 42 42 42h11.5c9.6 0 17.5-7.9 17.5-17.5S93.1 130 83.5 130H74c-8.3 0-15-6.7-15-15 0-6 3.6-11.5 9.2-13.8l28.4-13.6C109.8 81.2 118 69.1 118 54Z" fill="url(#gIcon-navbar)"/>
                <path d="M78 60c2 0 3.8 0.5 5.5 1.6l16.2 10c4.6 2.8 4.6 9.4 0 12.2l-16.2 10A10 10 0 0 1 68 85.9V70.1A10 10 0 0 1 78 60Z" fill="#0D0F17" opacity="0.9"/>
            </svg>
            <span class="fw-bold text-danger fs-3">Streamflix</span>
        </a>
        <div class="d-flex">
            <a href="pages/login.php" class="btn btn-outline-light me-2">Inloggen</a>
            <a href="pages/register.php" class="btn btn-danger">Gratis Proberen</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<!-- <section class="landing-hero-section d-flex align-items-center">
    <div class="floating-element floating-element-1">
        <i class="bi bi-play-circle floating-icon-4rem"></i>
    </div>
    <div class="floating-element floating-element-2">
        <i class="bi bi-film floating-icon-3rem"></i>
    </div>
    <div class="floating-element floating-element-3">
        <i class="bi bi-tv floating-icon-3-5rem"></i>
    </div>
     -->
    <div class="container hero-content">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <h1 class="display-2 fw-bold mb-4">
                    Unlimited <span class="text-danger">films</span>, 
                    TV shows & more
                </h1>
                <h2 class="h4 text-secondary mb-4">
                    Kijk waar je wilt. Zeg op wanneer je wilt.
                </h2>
                <p class="lead mb-5">
                    Stream duizenden award-winnende films, binge-waardige TV-shows, 
                    documentaires en meer op al je apparaten.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="pages/register.php" class="btn btn-danger btn-lg px-5">
                        <i class="bi bi-play-fill me-2"></i>Gratis Proberen
                    </a>
                    <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#demoModal">
                        <i class="bi bi-info-circle me-2"></i>Meer Info
                    </button>
                </div>
                <small class="text-secondary mt-3 d-block">
                    Geen contracten. Zeg op wanneer je wilt.
                </small>
            </div>
            <div class="col-lg-6 text-center">
                <div class="position-relative">
                    <img src="assets/img/background.jpg" alt="Streamflix Preview" 
                         class="img-fluid rounded shadow-lg hero-preview-img">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-dark">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-3">Waarom Streamflix?</h2>
                <p class="lead text-secondary">
                    Ontdek waarom miljoenen mensen kiezen voor de beste streaming ervaring
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <div class="feature-icon mb-3">
                    <i class="bi bi-infinity"></i>
                </div>
                <h4 class="fw-bold">Unlimited Content</h4>
                <p class="text-secondary">
                    Stream zoveel je wilt, wanneer je wilt. Geen advertenties, geen onderbrekingen.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <div class="feature-icon mb-3">
                    <i class="bi bi-display"></i>
                </div>
                <h4 class="fw-bold">Alle Apparaten</h4>
                <p class="text-secondary">
                    Kijk op je TV, laptop, tablet of telefoon. Download voor offline kijken.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <div class="feature-icon mb-3">
                    <i class="bi bi-badge-4k"></i>
                </div>
                <h4 class="fw-bold">4K Ultra HD</h4>
                <p class="text-secondary">
                    Geniet van kristalheldere beeldkwaliteit tot 4K Ultra HD met Dolby Audio.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="py-5 pricing-section-bg">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-3">Kies je abonnement</h2>
                <p class="lead text-secondary">
                    Flexibel, transparant en zonder verborgen kosten
                </p>
            </div>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-lg-3 col-md-6">
                <div class="card bg-dark border-secondary plan-card h-100">
                    <div class="card-body text-center p-4">
                        <h5 class="card-title fw-bold">Basis</h5>
                        <div class="mb-3">
                            <span class="h2 fw-bold text-danger">€7.99</span>
                            <span class="text-secondary">/maand</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check text-success me-2"></i>HD kwaliteit</li>
                            <li class="mb-2"><i class="bi bi-check text-success me-2"></i>1 scherm tegelijk</li>
                            <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Unlimited content</li>
                            <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Alle apparaten</li>
                        </ul>
                        <a href="pages/register.php?plan=basis" class="btn btn-outline-danger w-100">Kies Basis</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-danger border-0 plan-card h-100 position-relative">
                    <div class="card-body text-center p-4">
                        <h5 class="card-title fw-bold">Standaard</h5>
                        <div class="mb-3">
                            <span class="h2 fw-bold">€11.99</span>
                            <span>/maand</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check text-light me-2"></i>Full HD kwaliteit</li>
                            <li class="mb-2"><i class="bi bi-check text-light me-2"></i>2 schermen tegelijk</li>
                            <li class="mb-2"><i class="bi bi-check text-light me-2"></i>Unlimited content</li>
                            <li class="mb-2"><i class="bi bi-check text-light me-2"></i>Download functie</li>
                        </ul>
                        <a href="pages/register.php?plan=standaard" class="btn btn-light w-100 fw-bold">Kies Standaard</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-dark border-warning plan-card h-100">
                    <div class="card-body text-center p-4">
                        <h5 class="card-title fw-bold text-warning">Premium</h5>
                        <div class="mb-3">
                            <span class="h2 fw-bold text-warning">€15.99</span>
                            <span class="text-secondary">/maand</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check text-success me-2"></i>4K Ultra HD</li>
                            <li class="mb-2"><i class="bi bi-check text-success me-2"></i>4 schermen tegelijk</li>
                            <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Premium content</li>
                            <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Dolby Atmos</li>
                        </ul>
                        <a href="pages/register.php?plan=premium" class="btn btn-warning text-dark w-100 fw-bold">Kies Premium</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <p class="text-secondary">
                <i class="bi bi-shield-check me-2"></i>
                30 dagen geld-terug-garantie • Zeg op wanneer je wilt • Geen contracten
            </p>
        </div>
    </div>
</section>

<!-- Demo Modal -->
<div class="modal fade" id="demoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Over Streamflix</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-danger">🎬 Premium Content</h6>
                        <p>Toegang tot award-winnende originele series, blockbuster films en documentaires.</p>
                        
                        <h6 class="text-danger mt-3">📱 Alle Apparaten</h6>
                        <p>Stream op Smart TV's, laptops, tablets, smartphones en gaming consoles.</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-danger">🌟 Personalisatie</h6>
                        <p>Intelligente aanbevelingen gebaseerd op je kijkgedrag en voorkeuren.</p>
                        
                        <h6 class="text-danger mt-3">👨‍👩‍👧‍👦 Familie Vriendelijk</h6>
                        <p>Aparte profielen voor kinderen met leeftijdsgeschikte content en ouderlijk toezicht.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <a href="pages/register.php" class="btn btn-danger">Start Nu</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark py-4 border-top border-secondary">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <svg width="30" height="30" viewBox="0 0 150 165" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                        <defs>
                            <linearGradient id="gIcon-footer" x1="12" y1="12" x2="132" y2="132" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FF2E63"/>
                                <stop offset="0.5" stop-color="#FF5F32"/>
                                <stop offset="1" stop-color="#FF8A00"/>
                            </linearGradient>
                        </defs>
                        <path d="M118 54c0-24.3-18.7-42-42-42H66.5c-9.6 0-17.5 7.9-17.5 17.5S56.9 47 66.5 47H76c8.3 0 15 6.7 15 15 0 6-3.6 11.5-9.2 13.8L53.4 89.4C38.2 95.8 30 107.9 30 123c0 24.3 18.7 42 42 42h11.5c9.6 0 17.5-7.9 17.5-17.5S93.1 130 83.5 130H74c-8.3 0-15-15 0-6 3.6-11.5 9.2-13.8l28.4-13.6C109.8 81.2 118 69.1 118 54Z" fill="url(#gIcon-footer)"/>
                        <path d="M78 60c2 0 3.8 0.5 5.5 1.6l16.2 10c4.6 2.8 4.6 9.4 0 12.2l-16.2 10A10 10 0 0 1 68 85.9V70.1A10 10 0 0 1 78 60Z" fill="#0D0F17" opacity="0.9"/>
                    </svg>
                    <span class="fw-bold text-danger">STREAMFLIX</span>
                </div>
                <p class="text-secondary mb-0 mt-2">&copy; 2023 Streamflix. Alle rechten voorbehouden.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="d-flex gap-3 justify-content-md-end">
                    <a href="pages/terms.php" class="text-secondary text-decoration-none">Algemene Voorwaarden</a>
                    <a href="pages/privacy-policy.php" class="text-secondary text-decoration-none">Privacy</a>
                    <a href="pages/contact.php" class="text-secondary text-decoration-none">Contact</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>