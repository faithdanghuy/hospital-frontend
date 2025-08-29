<?php
$name = $item['drug_name'] ?? 'Unknown Medication';
?>

<?php ob_start(); ?>
<div class="profile-container">
  <div class="profile-card">
    <div class="profile-header">
      <h2 class="profile-name"><?= htmlspecialchars($name) ?></h2>
      <p class="profile-id">ID: <?= htmlspecialchars($item['id'] ?? '-') ?></p>
    </div>

    <div class="profile-details">
      <p><strong>Price:</strong> <?= htmlspecialchars($item['price'] ?? '-') ?></p>
      <p><strong>Stock:</strong> <?= htmlspecialchars($item['stock'] ?? '-') ?></p>
      <p><strong>Unit:</strong> <?= htmlspecialchars($item['unit'] ?? '-') ?></p>
      <p><strong>Description:</strong> <?= htmlspecialchars($item['description'] ?? '-') ?></p>
    </div>

    <div class="profile-actions">
        <a href="/medication/edit/<?= urlencode($item['id'] ?? '') ?>" class="btn">Edit Medication</a>
        <a href="/medications" class="btn btn-secondary">Back</a>
    </div>
  </div>
</div>

<?php 
$content = ob_get_clean(); 
echo App\Core\View::render('partials/layout', compact('content')); 
?>
