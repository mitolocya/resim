<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/sales-step2.php';
require_once __DIR__ . '/sales-step3.php';

// JSON verilerini yükleme
$json_file = __DIR__ . '/car-data.json';
$brands = [];
if (file_exists($json_file)) {
    $data = file_get_contents($json_file);
    $brands = json_decode($data, true);
}
?>

<div id="auto-sales-widget" class="auto-sales-widget">
    <!-- Step 1 -->
    <div id="step1-container" class="form-container">
        <h2 class="widget-title">🚗 Uw Auto Verkopen</h2>
        <p class="widget-description">Kies een merk en voer het model van uw auto in om verder te gaan.</p>
        <form id="formauto" class="auto-sales-form" data-container="step1">
            <input type="hidden" name="brand" value="<?php echo htmlspecialchars($_GET['brand'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="model" value="<?php echo htmlspecialchars($_GET['model'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-group">
                <label for="brand" class="form-label">
                    <i class="fas fa-car"></i> Merk <span class="required">*</span>
                </label>
                <select id="brand" name="brand" class="form-input" required>
                    <option value="">Kies een merk</option>
                    <?php foreach ($brands as $brand => $models): ?>
                        <option value="<?php echo htmlspecialchars($brand); ?>"><?php echo htmlspecialchars($brand); ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="model" class="form-label">
                    <i class="fas fa-cogs"></i> Model <span class="required">*</span>
                </label>
                <input type="text" id="model" name="model" class="form-input" placeholder="Voer het model in" required>
                <span class="error-message"></span>
            </div>
            <button type="submit" class="form-submit-btn">
                <i class="fas fa-arrow-right"></i> Volgende Stap
            </button>
        </form>
    </div>
    <!-- Step 2 -->
    <div id="step2-container" class="form-container" style="display: none;">
        <?php render_sales_step2(); ?>
    </div>
    <!-- Step 3 -->
    <div id="step3-container" class="form-container" style="display: none;">
        <?php render_sales_step3(); ?>
    </div>
</div>