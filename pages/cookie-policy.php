<?php
include '../includes/header.php';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold text-danger mb-4 text-center">Cookiebeleid</h1>
            
            <div class="card bg-dark text-white border-secondary">
                <div class="card-body">
                    <p class="text-secondary">
                        <small>Laatst bijgewerkt: <?= date('d F Y') ?></small>
                    </p>

                    <div class="mb-4">
                        <h4 class="text-danger">1. Wat zijn Cookies?</h4>
                        <p>
                            Cookies zijn kleine tekstbestanden die worden opgeslagen op uw apparaat (computer, tablet of smartphone) wanneer u onze website bezoekt. Deze bestanden helpen ons de website beter te laten functioneren en uw ervaring te personaliseren.
                        </p>
                        
                        <div class="alert alert-info bg-info text-dark">
                            <i class="bi bi-lightbulb me-2"></i>
                            <strong>Wist u dat?</strong> Cookies bevatten geen persoonlijke informatie zoals uw naam of e-mailadres, tenzij u deze vrijwillig verstrekt.
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">2. Welke Cookies Gebruiken Wij?</h4>
                        
                        <div class="accordion" id="cookieAccordion">
                            <!-- Essential Cookies -->
                            <div class="accordion-item bg-dark border-secondary">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#essential">
                                        <span class="badge bg-success me-2">Noodzakelijk</span>
                                        Essentiële Cookies
                                    </button>
                                </h2>
                                <div id="essential" class="accordion-collapse collapse show" data-bs-parent="#cookieAccordion">
                                    <div class="accordion-body bg-dark">
                                        <p class="text-secondary">Deze cookies zijn noodzakelijk voor het functioneren van de website.</p>
                                        <div class="table-responsive">
                                            <table class="table table-dark table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Cookie</th>
                                                        <th>Doel</th>
                                                        <th>Duur</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>PHPSESSID</td>
                                                        <td>Sessie beheer en inlogstatus</td>
                                                        <td>Sessie</td>
                                                    </tr>
                                                    <tr>
                                                        <td>csrf_token</td>
                                                        <td>Beveiliging tegen CSRF aanvallen</td>
                                                        <td>Sessie</td>
                                                    </tr>
                                                    <tr>
                                                        <td>cookie_consent</td>
                                                        <td>Opslaan van cookie voorkeuren</td>
                                                        <td>1 jaar</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Functional Cookies -->
                            <div class="accordion-item bg-dark border-secondary">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#functional">
                                        <span class="badge bg-warning text-dark me-2">Optioneel</span>
                                        Functionele Cookies
                                    </button>
                                </h2>
                                <div id="functional" class="accordion-collapse collapse" data-bs-parent="#cookieAccordion">
                                    <div class="accordion-body bg-dark">
                                        <p class="text-secondary">Deze cookies verbeteren de functionaliteit en personalisatie.</p>
                                        <div class="table-responsive">
                                            <table class="table table-dark table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Cookie</th>
                                                        <th>Doel</th>
                                                        <th>Duur</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>user_preferences</td>
                                                        <td>Opslaan van gebruikersvoorkeuren</td>
                                                        <td>6 maanden</td>
                                                    </tr>
                                                    <tr>
                                                        <td>theme_mode</td>
                                                        <td>Donker/licht thema voorkeur</td>
                                                        <td>1 jaar</td>
                                                    </tr>
                                                    <tr>
                                                        <td>language</td>
                                                        <td>Taalvoorkeur onthouden</td>
                                                        <td>1 jaar</td>
                                                    </tr>
                                                    <tr>
                                                        <td>video_quality</td>
                                                        <td>Gewenste videokwaliteit</td>
                                                        <td>3 maanden</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Analytics Cookies -->
                            <div class="accordion-item bg-dark border-secondary">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#analytics">
                                        <span class="badge bg-info me-2">Optioneel</span>
                                        Analytics Cookies
                                    </button>
                                </h2>
                                <div id="analytics" class="accordion-collapse collapse" data-bs-parent="#cookieAccordion">
                                    <div class="accordion-body bg-dark">
                                        <p class="text-secondary">Deze cookies helpen ons de website te verbeteren door gebruiksstatistieken te verzamelen.</p>
                                        <div class="table-responsive">
                                            <table class="table table-dark table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Cookie</th>
                                                        <th>Provider</th>
                                                        <th>Doel</th>
                                                        <th>Duur</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>_ga</td>
                                                        <td>Google Analytics</td>
                                                        <td>Gebruiker identificatie</td>
                                                        <td>2 jaar</td>
                                                    </tr>
                                                    <tr>
                                                        <td>_gid</td>
                                                        <td>Google Analytics</td>
                                                        <td>Sessie identificatie</td>
                                                        <td>24 uur</td>
                                                    </tr>
                                                    <tr>
                                                        <td>_gat</td>
                                                        <td>Google Analytics</td>
                                                        <td>Request rate beperking</td>
                                                        <td>1 minuut</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Performance Cookies -->
                            <div class="accordion-item bg-dark border-secondary">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#performance">
                                        <span class="badge bg-warning text-dark me-2">Optioneel</span>
                                        Prestatie Cookies
                                    </button>
                                </h2>
                                <div id="performance" class="accordion-collapse collapse" data-bs-parent="#cookieAccordion">
                                    <div class="accordion-body bg-dark">
                                        <p class="text-secondary">Deze cookies monitoren de prestaties van onze streaming service.</p>
                                        <div class="table-responsive">
                                            <table class="table table-dark table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Cookie</th>
                                                        <th>Doel</th>
                                                        <th>Duur</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>stream_quality</td>
                                                        <td>Monitoring van streamkwaliteit</td>
                                                        <td>Sessie</td>
                                                    </tr>
                                                    <tr>
                                                        <td>buffer_events</td>
                                                        <td>Tracking van buffering gebeurtenissen</td>
                                                        <td>Sessie</td>
                                                    </tr>
                                                    <tr>
                                                        <td>connection_speed</td>
                                                        <td>Internetsnelheid meting</td>
                                                        <td>1 uur</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">3. Uw Cookievoorkeuren Beheren</h4>
                        <p>
                            U heeft volledige controle over welke cookies u wilt accepteren:
                        </p>
                        
                        <!-- Cookie Preferences Simulator -->
                        <div class="card bg-secondary border-0">
                            <div class="card-header">
                                <h6 class="mb-0">Cookie Instellingen</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="essentialCookies" checked disabled>
                                            <label class="form-check-label" for="essentialCookies">
                                                <strong>Noodzakelijke Cookies</strong><br>
                                                <small class="text-secondary">Altijd actief - nodig voor basisfunctionaliteit</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="functionalCookies" checked>
                                            <label class="form-check-label" for="functionalCookies">
                                                <strong>Functionele Cookies</strong><br>
                                                <small class="text-secondary">Verbeterde gebruikerservaring</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="analyticsCookies">
                                            <label class="form-check-label" for="analyticsCookies">
                                                <strong>Analytics Cookies</strong><br>
                                                <small class="text-secondary">Helpt ons de website te verbeteren</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="performanceCookies">
                                            <label class="form-check-label" for="performanceCookies">
                                                <strong>Prestatie Cookies</strong><br>
                                                <small class="text-secondary">Optimalisatie van streaming</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-success" onclick="saveCookiePreferences()">
                                        <i class="bi bi-check-circle me-2"></i>Voorkeuren Opslaan
                                    </button>
                                    <button class="btn btn-outline-light" onclick="acceptAllCookies()">
                                        Alles Accepteren
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="rejectOptionalCookies()">
                                        Alleen Noodzakelijke
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">4. Browser Instellingen</h4>
                        <p>
                            U kunt ook cookies beheren via uw browserinstellingen:
                        </p>
                        
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <div class="text-center">
                                    <i class="bi bi-browser-chrome display-4 text-warning"></i>
                                    <h6 class="mt-2">Chrome</h6>
                                    <a href="#" class="btn btn-outline-warning btn-sm">Gids</a>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="text-center">
                                    <i class="bi bi-browser-firefox display-4 text-danger"></i>
                                    <h6 class="mt-2">Firefox</h6>
                                    <a href="#" class="btn btn-outline-danger btn-sm">Gids</a>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="text-center">
                                    <i class="bi bi-browser-safari display-4 text-info"></i>
                                    <h6 class="mt-2">Safari</h6>
                                    <a href="#" class="btn btn-outline-info btn-sm">Gids</a>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="text-center">
                                    <i class="bi bi-browser-edge display-4 text-primary"></i>
                                    <h6 class="mt-2">Edge</h6>
                                    <a href="#" class="btn btn-outline-primary btn-sm">Gids</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">5. Gevolgen van Uitschakelen</h4>
                        <div class="alert alert-warning text-dark">
                            <strong>Let op:</strong> Het uitschakelen van bepaalde cookies kan invloed hebben op uw ervaring:
                            <ul class="mt-2 mb-0">
                                <li>Verlies van persoonlijke voorkeuren</li>
                                <li>Minder nauwkeurige aanbevelingen</li>
                                <li>Herhaalde cookie-notificaties</li>
                                <li>Mogelijk slechtere streaming prestaties</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">6. Third-Party Cookies</h4>
                        <p>
                            Sommige cookies worden geplaatst door externe diensten die we gebruiken:
                        </p>
                        
                        <div class="table-responsive">
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr class="table-danger">
                                        <th>Service</th>
                                        <th>Doel</th>
                                        <th>Privacy Beleid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Google Analytics</td>
                                        <td>Website statistieken</td>
                                        <td><a href="#" class="text-warning">Google Privacy</a></td>
                                    </tr>
                                    <tr>
                                        <td>YouTube</td>
                                        <td>Video inhoud</td>
                                        <td><a href="#" class="text-warning">YouTube Privacy</a></td>
                                    </tr>
                                    <tr>
                                        <td>Stripe</td>
                                        <td>Betalingsverwerking</td>
                                        <td><a href="#" class="text-warning">Stripe Privacy</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">7. Contact</h4>
                        <p>
                            Vragen over ons cookiebeleid? Neem contact op:
                        </p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card bg-secondary border-0">
                                    <div class="card-body">
                                        <h6 class="text-warning">Privacy Team</h6>
                                        <p class="small mb-0">
                                            <i class="bi bi-envelope me-2"></i>privacy@streamflix.nl<br>
                                            <i class="bi bi-telephone me-2"></i>+31 20 123 4567
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-secondary border-0">
                                    <div class="card-body">
                                        <h6 class="text-warning">Postadres</h6>
                                        <p class="small mb-0">
                                            Streamflix B.V.<br>
                                            Keizersgracht 123<br>
                                            1015 CJ Amsterdam
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info bg-info text-dark">
                        <strong>Transparantie is belangrijk:</strong> Wij geloven in volledige transparantie over hoe we cookies gebruiken. Dit beleid wordt regelmatig bijgewerkt.
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="text-center mt-4">
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <a href="terms.php" class="btn btn-outline-danger">
                        <i class="bi bi-file-text me-2"></i>Algemene Voorwaarden
                    </a>
                    <a href="privacy-policy.php" class="btn btn-outline-warning">
                        <i class="bi bi-shield-check me-2"></i>Privacybeleid
                    </a>
                    <a href="../home.php" class="btn btn-danger">
                        <i class="bi bi-house me-2"></i>Terug naar Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function saveCookiePreferences() {
    const functional = document.getElementById('functionalCookies').checked;
    const analytics = document.getElementById('analyticsCookies').checked;
    const performance = document.getElementById('performanceCookies').checked;
    
    // In a real application, this would save preferences to server
    localStorage.setItem('cookiePreferences', JSON.stringify({
        functional: functional,
        analytics: analytics,
        performance: performance
    }));
    
    alert('Cookie voorkeuren opgeslagen!');
}

function acceptAllCookies() {
    document.getElementById('functionalCookies').checked = true;
    document.getElementById('analyticsCookies').checked = true;
    document.getElementById('performanceCookies').checked = true;
    saveCookiePreferences();
}

function rejectOptionalCookies() {
    document.getElementById('functionalCookies').checked = false;
    document.getElementById('analyticsCookies').checked = false;
    document.getElementById('performanceCookies').checked = false;
    saveCookiePreferences();
}
</script>

<?php include '../includes/footer.php'; ?>