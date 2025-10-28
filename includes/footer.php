</div>
    <footer class="bg-dark text-white py-5 mt-5 border-top border-secondary">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 col-lg-3">
                    <div class="d-flex align-items-center mb-3">
                        <svg width="30" height="30" viewBox="0 0 150 165" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="streamflix-footer-logo" class="me-2">
                            <title id="streamflix-footer-logo">Streamflix Logo</title>
                            <defs>
                                <linearGradient id="gIcon-footer" x1="12" y1="12" x2="132" y2="132" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FF2E63"/>
                                    <stop offset="0.5" stop-color="#FF5F32"/>
                                    <stop offset="1" stop-color="#FF8A00"/>
                                </linearGradient>
                            </defs>
                            <path d="M118 54c0-24.3-18.7-42-42-42H66.5c-9.6 0-17.5 7.9-17.5 17.5S56.9 47 66.5 47H76c8.3 0 15 6.7 15 15 0 6-3.6 11.5-9.2 13.8L53.4 89.4C38.2 95.8 30 107.9 30 123c0 24.3 18.7 42 42 42h11.5c9.6 0 17.5-7.9 17.5-17.5S93.1 130 83.5 130H74c-8.3 0-15-6.7-15-15 0-6 3.6-11.5 9.2-13.8l28.4-13.6C109.8 81.2 118 69.1 118 54Z" fill="url(#gIcon-footer)"/>
                            <path d="M78 60c2 0 3.8 0.5 5.5 1.6l16.2 10c4.6 2.8 4.6 9.4 0 12.2l-16.2 10A10 10 0 0 1 68 85.9V70.1A10 10 0 0 1 78 60Z" fill="#0D0F17" opacity="0.9"/>
                        </svg>
                        <h5 class="fw-bold text-danger mb-0">STREAMFLIX</h5>
                    </div>
                    <p class="text-secondary mb-3">De beste films en series, altijd en overal beschikbaar.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-secondary fs-5 hover-text-danger"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-secondary fs-5 hover-text-danger"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-secondary fs-5 hover-text-danger"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-secondary fs-5 hover-text-danger"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <h5 class="fw-bold mb-3">Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="home.php" class="text-secondary text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="pages/category.php" class="text-secondary text-decoration-none">Categorieën</a></li>
                        <li class="mb-2"><a href="pages/login.php" class="text-secondary text-decoration-none">Inloggen</a></li>
                        <li class="mb-2"><a href="pages/register.php" class="text-secondary text-decoration-none">Registreren</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <h5 class="fw-bold mb-3">Ondersteuning</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="pages/faq.php" class="text-secondary text-decoration-none">FAQ</a></li>
                        <li class="mb-2"><a href="pages/contact.php" class="text-secondary text-decoration-none">Contact</a></li>
                        <li class="mb-2"><a href="pages/helpdesk.php" class="text-secondary text-decoration-none">Helpdesk</a></li>
                        <li class="mb-2"><a href="pages/account.php" class="text-secondary text-decoration-none">Account</a></li>
                    </ul>
                </div>
                <div class="col-md-12 col-lg-3">
                    <h5 class="fw-bold mb-3">Juridisch</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="pages/terms.php" class="text-secondary text-decoration-none">Algemene Voorwaarden</a></li>
                        <li class="mb-2"><a href="pages/privacy-policy.php" class="text-secondary text-decoration-none">Privacybeleid</a></li>
                        <li class="mb-2"><a href="pages/cookie-policy.php" class="text-secondary text-decoration-none">Cookiebeleid</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary mt-4 pt-4 text-center text-secondary">
                <p>&copy; 2023 Streamflix. Alle rechten voorbehouden.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Video.js -->
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
    <!-- Custom Scripts -->
    <script src="<?php echo (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) ? '../assets/js/script.js' : 'assets/js/script.js'; ?>"></script>
</body>
</html>