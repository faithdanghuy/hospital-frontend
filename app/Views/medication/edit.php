<?php ob_start(); ?>
<h1>Edit Medication</h1>

<?php if (!empty($error)): ?>
  <div class="alert error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="/medication/update/<?= urlencode($item['id'] ?? '') ?>">
  <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

  <label>Medication Name</label>
  <input id="drug_name" name="drug_name" 
         value="<?= htmlspecialchars($item['drug_name'] ?? '') ?>" 
         placeholder="Medication Name"
         required>

  <label>Stock</label>
  <input id="stock" name="stock" type="number"
         oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
         pattern="[0-9]*" 
         inputmode="numeric"
         placeholder="Stock"
         min="0"
         value="<?= htmlspecialchars($item['stock'] ?? 0) ?>" 
         required>

  <label>Unit</label>
  <select id="unit" name="unit" required>
    <?php 
      $unit = $item['unit'] ?? 'tablet';
      $options = ['tablet', 'capsule', 'syrup', 'injection', 'ointment', 'drop', 'inhaler', 'patch', 'suppository', 'other'];
      foreach ($options as $opt): 
    ?>
      <option value="<?= $opt ?>" <?= $unit === $opt ? 'selected' : '' ?>>
        <?= ucfirst($opt) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label for="description">Description</label>
  <input id="description" name="description" value="<?= htmlspecialchars($item['description'] ?? '') ?>" required>

  <button type="submit">Save</button>
</form>

<?php 
$content = ob_get_clean(); 
echo App\Core\View::render('partials/layout', compact('content')); 
?>
