<?php
function render_sales_step2() {
    ?>
    <div class="auto-sales-step2">
        <h2 class="widget-title">🚘 Auto Informatie</h2>
        <p class="widget-description">Vul aanvullende informatie over uw auto in.</p>
        <form id="formauto-step2" class="auto-sales-form" data-container="step2">
            <!-- Bouwjaar -->
            <div class="form-group">
                <label for="year" class="form-label">
                    <i class="fas fa-calendar-alt"></i> Bouwjaar <span class="required">*</span>
                </label>
                <select id="year" name="year" class="form-input" required>
                    <option value="">Kies een bouwjaar</option>
                    <?php for ($year = date('Y'); $year >= 1970; $year--): ?>
                        <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
                    <?php endfor; ?>
                </select>
                <span class="error-message"></span>
            </div>

            <!-- Transmissie -->
            <div class="form-group">
                <label for="transmission" class="form-label">
                    <i class="fas fa-cogs"></i> Transmissie <span class="required">*</span>
                </label>
                <select id="transmission" name="transmission" class="form-input" required>
                    <option value="">Kies een transmissie</option>
                    <option value="automaat">Automaat</option>
                    <option value="handgeschakeld">Handgeschakeld</option>
                </select>
                <span class="error-message"></span>
            </div>

            <!-- Brandstof -->
            <div class="form-group">
                <label for="fuel" class="form-label">
                    <i class="fas fa-gas-pump"></i> Brandstof <span class="required">*</span>
                </label>
                <select id="fuel" name="fuel" class="form-input" required>
                    <option value="">Kies een brandstof</option>
                    <option value="benzine">Benzine</option>
                    <option value="diesel">Diesel</option>
                    <option value="elektrisch">Elektrisch</option>
                    <option value="hybride-benzine">Hybride Elektrisch/Benzine</option>
                    <option value="hybride-diesel">Hybride Elektrisch/Diesel</option>
                    <option value="lpg">LPG</option>
                    <option value="cng">CNG (Aardgas)</option>
                    <option value="waterstof">Waterstof</option>
                    <option value="overige-brandstoffen">Overige brandstoffen</option>
                </select>
                <span class="error-message"></span>
            </div>

            <!-- KM-Stand -->
            <div class="form-group">
                <label for="kmstand" class="form-label">
                    <i class="fas fa-tachometer-alt"></i> KM-Stand <span class="required">*</span>
                </label>
                <input type="number" id="kmstand" name="kmstand" class="form-input" placeholder="Voer kilometerstand in" required>
                <span class="error-message"></span>
            </div>

            <!-- Deuren -->
            <div class="form-group">
                <label for="doors" class="form-label">
                    <i class="fas fa-door-closed"></i> Deuren <span class="required">*</span>
                </label>
                <select id="doors" name="doors" class="form-input" required>
                    <option value="">Kies een type deur</option>
                    <option value="1-deurs">1 Deurs</option>
                    <option value="2-deurs">2 Deurs</option>
                    <option value="3-deurs">3 Deurs</option>
                    <option value="4-deurs">4 Deurs</option>
                    <option value="5-deurs">5 Deurs</option>
                    <option value="break">Break</option>
                </select>
                <span class="error-message"></span>
            </div>

            <!-- Carosserie Kleur -->
            <div class="form-group">
                <label for="color" class="form-label">
                    <i class="fas fa-palette"></i> Carosserie Kleur <span class="required">*</span>
                </label>
                <select id="color" name="color" class="form-input" required>
                    <option value="">Kies een kleur</option>
                    <option value="blauw">Blauw</option>
                    <option value="rood">Rood</option>
                    <option value="zilver-of-grijs">Zilver of Grijs</option>
                    <option value="zwart">Zwart</option>
                    <option value="beige">Beige</option>
                    <option value="bruin">Bruin</option>
                    <option value="groen">Groen</option>
                    <option value="wit">Wit</option>
                    <option value="overige-kleuren">Overige kleuren</option>
                </select>
                <span class="error-message"></span>
            </div>

            <!-- Interieur Kleur -->
            <div class="form-group">
                <label for="interior-color" class="form-label">
                    <i class="fas fa-paint-brush"></i> Interieur Kleur <span class="required">*</span>
                </label>
                <select id="interior-color" name="interior-color" class="form-input" required>
                    <option value="">Kies een interieur kleur</option>
                    <option value="beige">Beige</option>
                    <option value="blauw">Blauw</option>
                    <option value="bruin">Bruin</option>
                    <option value="grijs">Grijs</option>
                    <option value="zwart">Zwart</option>
                    <option value="overige-kleuren">Overige kleuren</option>
                </select>
                <span class="error-message"></span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="form-submit-btn">
                <i class="fas fa-arrow-right"></i> Volgende Stap
            </button>
        </form>
    </div>
    <?php
}
?>