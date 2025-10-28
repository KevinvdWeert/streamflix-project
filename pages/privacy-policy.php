<?php
include '../includes/header.php';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold text-danger mb-4 text-center">Privacybeleid</h1>
            
            <div class="card bg-dark text-white border-secondary">
                <div class="card-body">
                    <p class="text-secondary">
                        <small>Laatst bijgewerkt: <?= date('d F Y') ?></small>
                    </p>

                    <div class="mb-4">
                        <h4 class="text-danger">1. Inleiding</h4>
                        <p>
                            Streamflix B.V. ("Streamflix", "wij", "ons") respecteert uw privacy en is toegewijd aan het beschermen van uw persoonlijke gegevens. Dit privacybeleid legt uit hoe wij informatie over u verzamelen, gebruiken, delen en beschermen wanneer u onze streamingservice gebruikt.
                        </p>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">2. Welke Gegevens Verzamelen Wij</h4>
                        
                        <h6 class="text-warning">Accountinformatie:</h6>
                        <ul class="text-secondary">
                            <li>Naam en e-mailadres</li>
                            <li>Gebruikersnaam en wachtwoord</li>
                            <li>Geboortedatum (voor leeftijdsverificatie)</li>
                            <li>Betalingsgegevens</li>
                        </ul>

                        <h6 class="text-warning mt-3">Gebruiksgegevens:</h6>
                        <ul class="text-secondary">
                            <li>Kijkgeschiedenis en voorkeuren</li>
                            <li>Zoekgeschiedenis</li>
                            <li>Beoordelingen en recensies</li>
                            <li>Apparaat- en browserinformatie</li>
                            <li>IP-adres en locatiegegevens</li>
                        </ul>

                        <h6 class="text-warning mt-3">Technische gegevens:</h6>
                        <ul class="text-secondary">
                            <li>Cookies en vergelijkbare technologieën</li>
                            <li>Log-bestanden van serveractiviteit</li>
                            <li>Netwerkverbindingsinformatie</li>
                            <li>Prestatiemetingen</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">3. Hoe Gebruiken Wij Uw Gegevens</h4>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card bg-secondary border-0">
                                    <div class="card-body">
                                        <h6 class="text-warning">Service Levering</h6>
                                        <ul class="small text-light">
                                            <li>Content streamen</li>
                                            <li>Account beheer</li>
                                            <li>Betalingsverwerking</li>
                                            <li>Klantenservice</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-secondary border-0">
                                    <div class="card-body">
                                        <h6 class="text-warning">Personalisatie</h6>
                                        <ul class="small text-light">
                                            <li>Aanbevelingen</li>
                                            <li>Aangepaste inhoud</li>
                                            <li>Voorkeuren opslaan</li>
                                            <li>Gebruikerservaring verbeteren</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info bg-info text-dark mt-3">
                            <strong>Belangrijke opmerking:</strong> Wij verkopen uw persoonlijke gegevens nooit aan derden voor marketingdoeleinden.
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">4. Delen van Gegevens</h4>
                        <p>
                            Wij delen uw persoonlijke gegevens alleen in de volgende gevallen:
                        </p>
                        
                        <div class="table-responsive">
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr class="table-danger">
                                        <th>Partij</th>
                                        <th>Doel</th>
                                        <th>Gegevens</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Betalingsproviders</td>
                                        <td>Betalingsverwerking</td>
                                        <td>Betalingsgegevens</td>
                                    </tr>
                                    <tr>
                                        <td>Cloud providers</td>
                                        <td>Hosting en opslag</td>
                                        <td>Alle accountgegevens</td>
                                    </tr>
                                    <tr>
                                        <td>Analytics partners</td>
                                        <td>Service verbetering</td>
                                        <td>Geanonimiseerde gebruiksgegevens</td>
                                    </tr>
                                    <tr>
                                        <td>Wettelijke instanties</td>
                                        <td>Juridische verplichtingen</td>
                                        <td>Relevante gegevens</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">5. Uw Rechten (AVG/GDPR)</h4>
                        <p>
                            Onder de Algemene Verordening Gegevensbescherming (AVG) heeft u de volgende rechten:
                        </p>
                        
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="border border-secondary p-3 rounded">
                                    <h6 class="text-warning">Recht op toegang</h6>
                                    <small class="text-secondary">Vraag welke gegevens wij van u hebben</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border border-secondary p-3 rounded">
                                    <h6 class="text-warning">Recht op rectificatie</h6>
                                    <small class="text-secondary">Correctie van onjuiste gegevens</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border border-secondary p-3 rounded">
                                    <h6 class="text-warning">Recht op verwijdering</h6>
                                    <small class="text-secondary">"Recht om vergeten te worden"</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border border-secondary p-3 rounded">
                                    <h6 class="text-warning">Recht op overdraagbaarheid</h6>
                                    <small class="text-secondary">Export van uw gegevens</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="account.php" class="btn btn-warning">
                                <i class="bi bi-person-gear me-2"></i>Privacy Instellingen Beheren
                            </a>
                            <a href="contact.php?subject=privacy" class="btn btn-outline-warning">
                                <i class="bi bi-envelope me-2"></i>Privacy Verzoek Indienen
                            </a>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">6. Gegevensbeveiliging</h4>
                        <p>
                            Wij nemen de beveiliging van uw gegevens serieus en implementeren passende technische en organisatorische maatregelen:
                        </p>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="bi bi-shield-lock-fill display-4 text-success"></i>
                                    <h6 class="mt-2">Encryptie</h6>
                                    <small class="text-secondary">SSL/TLS voor gegevensoverdracht</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="bi bi-server display-4 text-info"></i>
                                    <h6 class="mt-2">Beveiligde Servers</h6>
                                    <small class="text-secondary">ISO 27001 gecertificeerde datacenters</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="bi bi-eye-slash-fill display-4 text-warning"></i>
                                    <h6 class="mt-2">Toegangscontrole</h6>
                                    <small class="text-secondary">Beperkte toegang op basis van functie</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">7. Internationale Overdrachten</h4>
                        <p>
                            Sommige van onze serviceproviders bevinden zich buiten de EU. Wij zorgen ervoor dat uw gegevens adequaat beschermd blijven door:
                        </p>
                        <ul class="text-secondary">
                            <li>Adequaatheidsbesluiten van de Europese Commissie</li>
                            <li>Standaard Contractuele Bepalingen (SCCs)</li>
                            <li>Binding Corporate Rules (BCRs)</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">8. Bewaartermijnen</h4>
                        <p>
                            Wij bewaren uw gegevens niet langer dan noodzakelijk:
                        </p>
                        
                        <div class="table-responsive">
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr class="table-danger">
                                        <th>Gegevenstype</th>
                                        <th>Bewaartermijn</th>
                                        <th>Reden</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Accountgegevens</td>
                                        <td>Zolang account actief is</td>
                                        <td>Service levering</td>
                                    </tr>
                                    <tr>
                                        <td>Kijkgeschiedenis</td>
                                        <td>2 jaar na laatste activiteit</td>
                                        <td>Aanbevelingen</td>
                                    </tr>
                                    <tr>
                                        <td>Betalingsgegevens</td>
                                        <td>7 jaar</td>
                                        <td>Wettelijke verplichting</td>
                                    </tr>
                                    <tr>
                                        <td>Log bestanden</td>
                                        <td>90 dagen</td>
                                        <td>Beveiliging en debugging</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">9. Wijzigingen in dit Beleid</h4>
                        <p>
                            Wij kunnen dit privacybeleid van tijd tot tijd bijwerken. Belangrijke wijzigingen worden u vooraf meegedeeld via:
                        </p>
                        <ul class="text-secondary">
                            <li>E-mailnotificatie naar uw geregistreerde e-mailadres</li>
                            <li>Prominente kennisgeving op onze website</li>
                            <li>In-app notificatie bij eerstvolgende gebruik</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-danger">10. Contact en Klachten</h4>
                        <p>
                            Voor vragen over dit privacybeleid of uw privacy rechten:
                        </p>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card bg-secondary border-0">
                                    <div class="card-body">
                                        <h6 class="text-warning">Privacy Officer</h6>
                                        <p class="small mb-1">
                                            <i class="bi bi-envelope me-2"></i>privacy@streamflix.nl<br>
                                            <i class="bi bi-telephone me-2"></i>+31 20 123 4567<br>
                                            <i class="bi bi-geo-alt me-2"></i>Keizersgracht 123, Amsterdam
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-secondary border-0">
                                    <div class="card-body">
                                        <h6 class="text-warning">Toezichthouder</h6>
                                        <p class="small mb-1">
                                            <strong>Autoriteit Persoonsgegevens</strong><br>
                                            <i class="bi bi-globe me-2"></i>autoriteitpersoonsgegevens.nl<br>
                                            <i class="bi bi-telephone me-2"></i>088 - 1805 250
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success text-dark">
                        <strong>Uw vertrouwen is waardevol:</strong> Wij doen er alles aan om uw privacy te respecteren en uw gegevens veilig te houden. Neem contact op als u vragen heeft.
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="text-center mt-4">
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <a href="terms.php" class="btn btn-outline-danger">
                        <i class="bi bi-file-text me-2"></i>Algemene Voorwaarden
                    </a>
                    <a href="cookie-policy.php" class="btn btn-outline-warning">
                        <i class="bi bi-info-circle me-2"></i>Cookiebeleid
                    </a>
                    <a href="../home.php" class="btn btn-danger">
                        <i class="bi bi-house me-2"></i>Terug naar Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>