<?php
function render_sales_step3() {
    ?>
    <div class="auto-sales-step3">
        <h2 class="widget-title">🚗 Uw Contactgegevens</h2>
        <p class="widget-description">Vul uw contactgegevens in zodat we u snel kunnen bereiken.</p>
        <form id="formauto-step3" class="auto-sales-form" data-container="step3">
            <div class="form-group">
                <label for="first-name" class="form-label">
                    <i class="fas fa-user"></i> Voornaam <span class="required">*</span>
                </label>
                <input type="text" id="first-name" name="first_name" class="form-input" placeholder="Uw voornaam" required>
                <span class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="last-name" class="form-label">
                    <i class="fas fa-user"></i> Achternaam <span class="required">*</span>
                </label>
                <input type="text" id="last-name" name="last_name" class="form-input" placeholder="Uw achternaam" required>
                <span class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Email <span class="required">*</span>
                </label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Uw emailadres" required>
                <span class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="phone" class="form-label">
                    <i class="fas fa-phone"></i> Telefoon <span class="required">*</span>
                </label>
                <input type="tel" id="phone" name="phone" class="form-input" placeholder="Uw telefoonnummer" required>
                <span class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="city" class="form-label">
                    <i class="fas fa-city"></i> Gemeente <span class="required">*</span>
                </label>
                <input type="text" id="city" name="city" class="form-input" placeholder="Uw gemeente" required>
                <span class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="extra-info" class="form-label">
                    <i class="fas fa-info-circle"></i> Extra informatie (optioneel)
                </label>
                <textarea id="extra-info" name="extra_info" class="form-input" rows="4" placeholder="Eventuele opmerkingen..."></textarea>
            </div>
            <button type="submit" class="form-submit-btn">
                <i class="fas fa-paper-plane"></i> Informatie Verzenden
            </button>
        </form>
    </div>
    <?php
}
?>