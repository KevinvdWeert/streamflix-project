<?php
include '../includes/header.php';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="fw-bold text-danger mb-4 text-center">Helpdesk & Ondersteuning</h1>
            
            <!-- Quick Actions -->
            <div class="row g-3 mb-5">
                <div class="col-md-3 col-6">
                    <div class="card bg-dark text-white border-secondary text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-question-circle-fill display-4 text-danger mb-2"></i>
                            <h6>FAQ</h6>
                            <a href="faq.php" class="btn btn-outline-danger btn-sm">Bekijk FAQ</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card bg-dark text-white border-secondary text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-envelope-fill display-4 text-warning mb-2"></i>
                            <h6>Contact</h6>
                            <a href="contact.php" class="btn btn-outline-warning btn-sm">Stuur Email</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card bg-dark text-white border-secondary text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-telephone-fill display-4 text-success mb-2"></i>
                            <h6>Bellen</h6>
                            <a href="tel:+31201234567" class="btn btn-outline-success btn-sm">020 123 4567</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card bg-dark text-white border-secondary text-center h-100">
                        <div class="card-body">
                            <i class="bi bi-chat-dots-fill display-4 text-info mb-2"></i>
                            <h6>Live Chat</h6>
                            <button class="btn btn-outline-info btn-sm" onclick="startChat()">Start Chat</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Common Issues -->
            <div class="card bg-dark text-white border-secondary mb-4">
                <div class="card-header bg-dark border-secondary">
                    <h4 class="mb-0 text-danger">Veelvoorkomende Problemen</h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="border-start border-danger ps-3">
                                <h6 class="text-danger">Video speelt niet af</h6>
                                <ul class="list-unstyled text-secondary small">
                                    <li>• Controleer je internetverbinding</li>
                                    <li>• Ververs de pagina (F5)</li>
                                    <li>• Wis je browsercache</li>
                                    <li>• Probeer een andere browser</li>
                                </ul>
                                <a href="faq.php#faq8" class="btn btn-outline-danger btn-sm">Meer info</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-start border-warning ps-3">
                                <h6 class="text-warning">Kan niet inloggen</h6>
                                <ul class="list-unstyled text-secondary small">
                                    <li>• Controleer gebruikersnaam en wachtwoord</li>
                                    <li>• Zorg dat Caps Lock uit staat</li>
                                    <li>• Probeer wachtwoord reset</li>
                                    <li>• Controleer je email voor activatie</li>
                                </ul>
                                <a href="faq.php#faq2" class="btn btn-outline-warning btn-sm">Meer info</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-start border-success ps-3">
                                <h6 class="text-success">Slechte videokwaliteit</h6>
                                <ul class="list-unstyled text-secondary small">
                                    <li>• Test je internetsnelheid</li>
                                    <li>• Sluit andere apps/downloads</li>
                                    <li>• Selecteer lagere kwaliteit</li>
                                    <li>• Gebruik bekabelde verbinding</li>
                                </ul>
                                <a href="faq.php#faq5" class="btn btn-outline-success btn-sm">Meer info</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-start border-info ps-3">
                                <h6 class="text-info">Account problemen</h6>
                                <ul class="list-unstyled text-secondary small">
                                    <li>• Wijzig je wachtwoord</li>
                                    <li>• Update je email adres</li>
                                    <li>• Bekijk je account instellingen</li>
                                    <li>• Contacteer support</li>
                                </ul>
                                <a href="account.php" class="btn btn-outline-info btn-sm">Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="card bg-dark text-white border-secondary mb-4">
                <div class="card-header bg-dark border-secondary">
                    <h4 class="mb-0 text-danger">Systeemstatus</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <small>Streaming Service</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <small>Website</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <small>Account Systeem</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <small>API Services</small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-secondary">
                            <i class="bi bi-clock"></i> Laatste update: <?= date('d-m-Y H:i') ?>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Troubleshooting Guide -->
            <div class="card bg-dark text-white border-secondary mb-4">
                <div class="card-header bg-dark border-secondary">
                    <h4 class="mb-0 text-danger">Probleemoplossing Stap-voor-Stap</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="accordion" id="troubleshootingAccordion">
                                <div class="accordion-item bg-dark border-secondary">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#step1">
                                            Stap 1: Basale Controles
                                        </button>
                                    </h2>
                                    <div id="step1" class="accordion-collapse collapse show" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body bg-dark text-secondary">
                                            <ol>
                                                <li>Controleer je internetverbinding</li>
                                                <li>Ververs de pagina (Ctrl+F5)</li>
                                                <li>Probeer in incognito/privé modus</li>
                                                <li>Test op een ander apparaat</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item bg-dark border-secondary">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#step2">
                                            Stap 2: Browser Instellingen
                                        </button>
                                    </h2>
                                    <div id="step2" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body bg-dark text-secondary">
                                            <ol>
                                                <li>Wis cache en cookies</li>
                                                <li>Schakel adblockers uit</li>
                                                <li>Update je browser</li>
                                                <li>Controleer JavaScript instellingen</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item bg-dark border-secondary">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#step3">
                                            Stap 3: Geavanceerde Oplossingen
                                        </button>
                                    </h2>
                                    <div id="step3" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body bg-dark text-secondary">
                                            <ol>
                                                <li>Reset je router/modem</li>
                                                <li>Gebruik bekabelde internetverbinding</li>
                                                <li>Wijzig DNS instellingen</li>
                                                <li>Contacteer je internetprovider</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-info bg-info text-dark">
                                <h6><i class="bi bi-lightbulb"></i> Pro Tip</h6>
                                <small>Probeer eerst stap 1 voordat je naar de volgende stap gaat. De meeste problemen worden opgelost met eenvoudige controles.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="text-center">
                <div class="card bg-dark border border-danger">
                    <div class="card-body">
                        <h4 class="text-danger mb-3">Nog steeds problemen?</h4>
                        <p class="text-secondary mb-3">Ons support team staat klaar om je te helpen!</p>
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <a href="contact.php" class="btn btn-danger">
                                <i class="bi bi-envelope me-2"></i>Email Support
                            </a>
                            <a href="tel:+31201234567" class="btn btn-outline-success">
                                <i class="bi bi-telephone me-2"></i>Bel Ons
                            </a>
                            <button class="btn btn-outline-info" onclick="startChat()">
                                <i class="bi bi-chat-dots me-2"></i>Live Chat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function startChat() {
    alert('Live chat wordt binnenkort geactiveerd! Voor nu kun je contact opnemen via email of telefoon.');
}
</script>

<?php include '../includes/footer.php'; ?>