<?php
include '../includes/header.php';
require_once '../includes/security-helper.php';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize contact form inputs
    $name = SecurityHelper::sanitizeString($_POST['name'] ?? '', 100);
    $email = SecurityHelper::sanitizeEmail($_POST['email'] ?? '');
    $subject = SecurityHelper::sanitizeString($_POST['subject'] ?? '', 20);
    $message = SecurityHelper::sanitizeString($_POST['message'] ?? '', 1000);
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_message = 'Alle velden zijn verplicht.';
    } elseif (!SecurityHelper::sanitizeEmail($email, true)) {
        $error_message = 'Ongeldig email adres.';
    } else {
        // In a real application, you would send an email or save to database
        $success_message = 'Bedankt voor je bericht! We nemen binnen 24 uur contact met je op.';
    }
}
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold text-danger mb-4 text-center">Contact Opnemen</h1>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success bg-success text-white border-0">
                    <i class="bi bi-check-circle me-2"></i><?= $success_message ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="alert alert-danger bg-danger text-white border-0">
                    <i class="bi bi-exclamation-circle me-2"></i><?= $error_message ?>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Contact Form -->
                <div class="col-md-8">
                    <div class="card bg-dark text-white border-secondary">
                        <div class="card-header bg-dark border-secondary">
                            <h4 class="mb-0">Stuur ons een bericht</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Naam *</label>
                                        <input type="text" class="form-control bg-dark text-white border-secondary" 
                                               id="name" name="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control bg-dark text-white border-secondary" 
                                               id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="subject" class="form-label">Onderwerp *</label>
                                        <select class="form-select bg-dark text-white border-secondary" id="subject" name="subject" required>
                                            <option value="">Kies een onderwerp</option>
                                            <option value="technical" <?= ($_POST['subject'] ?? '') === 'technical' ? 'selected' : '' ?>>Technische ondersteuning</option>
                                            <option value="account" <?= ($_POST['subject'] ?? '') === 'account' ? 'selected' : '' ?>>Account problemen</option>
                                            <option value="billing" <?= ($_POST['subject'] ?? '') === 'billing' ? 'selected' : '' ?>>Facturering</option>
                                            <option value="content" <?= ($_POST['subject'] ?? '') === 'content' ? 'selected' : '' ?>>Content verzoek</option>
                                            <option value="feedback" <?= ($_POST['subject'] ?? '') === 'feedback' ? 'selected' : '' ?>>Feedback</option>
                                            <option value="other" <?= ($_POST['subject'] ?? '') === 'other' ? 'selected' : '' ?>>Anders</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Bericht *</label>
                                        <textarea class="form-control bg-dark text-white border-secondary" 
                                                  id="message" name="message" rows="5" required 
                                                  placeholder="Beschrijf je vraag of probleem zo gedetailleerd mogelijk..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-send me-2"></i>Verstuur Bericht
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="col-md-4">
                    <div class="card bg-dark text-white border-secondary mb-3">
                        <div class="card-header bg-dark border-secondary">
                            <h5 class="mb-0">Contact Informatie</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-envelope-fill text-danger me-3 fs-5"></i>
                                <div>
                                    <strong>Email</strong><br>
                                    <small class="text-secondary">support@streamflix.nl</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-telephone-fill text-danger me-3 fs-5"></i>
                                <div>
                                    <strong>Telefoon</strong><br>
                                    <small class="text-secondary">+31 20 123 4567</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-clock-fill text-danger me-3 fs-5"></i>
                                <div>
                                    <strong>Openingstijden</strong><br>
                                    <small class="text-secondary">Ma-Vr: 9:00-18:00<br>Weekend: 10:00-16:00</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill text-danger me-3 fs-5"></i>
                                <div>
                                    <strong>Adres</strong><br>
                                    <small class="text-secondary">Streamflix BV<br>Keizersgracht 123<br>1015 CJ Amsterdam</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alternative Contact Methods -->
                    <div class="card bg-dark text-white border-secondary">
                        <div class="card-header bg-dark border-secondary">
                            <h5 class="mb-0">Andere Manieren</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="faq.php" class="btn btn-outline-danger">
                                    <i class="bi bi-question-circle me-2"></i>FAQ Bekijken
                                </a>
                                <a href="helpdesk.php" class="btn btn-outline-danger">
                                    <i class="bi bi-headset me-2"></i>Live Helpdesk
                                </a>
                                <a href="#" class="btn btn-outline-secondary">
                                    <i class="bi bi-chat-dots me-2"></i>Live Chat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Time Information -->
            <div class="alert alert-info bg-dark border border-secondary text-light mt-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="mb-1"><i class="bi bi-info-circle me-2"></i>Reactietijd</h6>
                        <small>We streven ernaar om binnen 24 uur te reageren op alle berichten. Voor urgente zaken kun je bellen tijdens kantooruren.</small>
                    </div>
                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                        <span class="badge bg-success fs-6">
                            <i class="bi bi-clock"></i> Gemiddeld 4 uur
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>