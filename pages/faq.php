<?php
include '../includes/header.php';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold text-danger mb-4 text-center">Veelgestelde Vragen</h1>
            
            <div class="accordion accordion-flush" id="faqAccordion">
                <!-- Account Questions -->
                <div class="card bg-dark border-secondary mb-2">
                    <div class="card-header bg-dark border-secondary">
                        <h4 class="text-danger mb-0">Account & Inloggen</h4>
                    </div>
                </div>
                
                <div class="accordion-item bg-dark border-secondary">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Hoe kan ik een account aanmaken?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body bg-dark text-secondary">
                            Klik op de "Registreren" knop in de rechterbovenhoek van de website. Vul je gewenste gebruikersnaam en wachtwoord in. Na registratie kun je direct inloggen en genieten van alle content.
                        </div>
                    </div>
                </div>

                <div class="accordion-item bg-dark border-secondary">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Ik ben mijn wachtwoord vergeten, wat nu?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body bg-dark text-secondary">
                            Neem contact op met onze helpdesk via de contactpagina. Vermeld je gebruikersnaam en wij helpen je verder met het resetten van je wachtwoord.
                        </div>
                    </div>
                </div>

                <!-- Streaming Questions -->
                <div class="card bg-dark border-secondary mb-2 mt-4">
                    <div class="card-header bg-dark border-secondary">
                        <h4 class="text-danger mb-0">Streaming & Kwaliteit</h4>
                    </div>
                </div>

                <div class="accordion-item bg-dark border-secondary">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Welke videokwaliteit wordt ondersteund?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body bg-dark text-secondary">
                            Streamflix ondersteunt HD (1080p) en 4K Ultra HD kwaliteit, afhankelijk van je internetverbinding en apparaat. De videokwaliteit wordt automatisch aangepast voor de beste kijkervaring.
                        </div>
                    </div>
                </div>

                <div class="accordion-item bg-dark border-secondary">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Op welke apparaten kan ik kijken?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body bg-dark text-secondary">
                            Je kunt Streamflix gebruiken op computers, tablets, smartphones, smart TV's en streaming apparaten. Elke moderne webbrowser wordt ondersteund.
                        </div>
                    </div>
                </div>

                <div class="accordion-item bg-dark border-secondary">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            Waarom hapert de video?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body bg-dark text-secondary">
                            Dit kan liggen aan je internetverbinding. Voor HD streaming heb je minimaal 5 Mbps nodig, voor 4K 25 Mbps. Controleer je internetsnelheid en probeer andere apparaten in je netwerk uit te zetten.
                        </div>
                    </div>
                </div>

                <!-- Content Questions -->
                <div class="card bg-dark border-secondary mb-2 mt-4">
                    <div class="card-header bg-dark border-secondary">
                        <h4 class="text-danger mb-0">Content & Beschikbaarheid</h4>
                    </div>
                </div>

                <div class="accordion-item bg-dark border-secondary">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                            Hoe vaak wordt nieuwe content toegevoegd?
                        </button>
                    </h2>
                    <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body bg-dark text-secondary">
                            We voegen wekelijks nieuwe films en series toe aan ons platform. Houd onze homepage in de gaten voor de nieuwste toevoegingen en aankomende releases.
                        </div>
                    </div>
                </div>

                <div class="accordion-item bg-dark border-secondary">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                            Kan ik content downloaden voor offline kijken?
                        </button>
                    </h2>
                    <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body bg-dark text-secondary">
                            Momenteel ondersteunen we alleen online streaming. Offline kijken wordt mogelijk in toekomstige updates geïntroduceerd.
                        </div>
                    </div>
                </div>

                <!-- Technical Questions -->
                <div class="card bg-dark border-secondary mb-2 mt-4">
                    <div class="card-header bg-dark border-secondary">
                        <h4 class="text-danger mb-0">Technische Ondersteuning</h4>
                    </div>
                </div>

                <div class="accordion-item bg-dark border-secondary">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                            Mijn video laadt niet, wat kan ik doen?
                        </button>
                    </h2>
                    <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body bg-dark text-secondary">
                            Probeer eerst je pagina te vernieuwen (F5). Als dit niet helpt, wis je browsercache en cookies. Controleer ook of je de nieuwste versie van je browser gebruikt.
                        </div>
                    </div>
                </div>

                <div class="accordion-item bg-dark border-secondary">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                            Welke browsers worden ondersteund?
                        </button>
                    </h2>
                    <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body bg-dark text-secondary">
                            Streamflix werkt het beste met de nieuwste versies van Chrome, Firefox, Safari, en Edge. Internet Explorer wordt niet meer ondersteund.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="text-center mt-5 p-4 bg-dark border border-secondary rounded">
                <h4 class="text-danger mb-3">Nog vragen?</h4>
                <p class="text-secondary mb-3">Kun je je vraag niet vinden? Neem contact op met ons support team.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="contact.php" class="btn btn-danger">
                        <i class="bi bi-envelope"></i> Contact
                    </a>
                    <a href="helpdesk.php" class="btn btn-outline-danger">
                        <i class="bi bi-headset"></i> Helpdesk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>