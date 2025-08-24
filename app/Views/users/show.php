<?php ob_start(); ?>
<h1>Profile</h1>

<div class="patient-profile">
  <div class="profile-header">
    <img class="avatar" src="<?= htmlspecialchars($item['avatar'] ?? '/images/default-avatar.png') ?>" alt="Avatar">
    <div class="profile-info">
      <h2><?= htmlspecialchars($item['name'] ?? 'Unknown') ?></h2>
      <p><strong>ID: </strong> <?= htmlspecialchars($item['id'] ?? '-') ?></p>
      <p><strong>Date of Birth: </strong> <?= htmlspecialchars($item['dob'] ?? '-') ?></p>
      <p><strong>Gender: </strong> <?= htmlspecialchars($item['gender'] ?? '-') ?></p>
    </div>
  </div>

  <div class="profile-details">
    <p><strong>Phone: </strong> <?= htmlspecialchars($item['phone'] ?? '-') ?></p>
    <p><strong>Address: </strong> <?= htmlspecialchars($item['address'] ?? '-') ?></p>
    <p><strong>Email: </strong> <?= htmlspecialchars($item['email'] ?? '-') ?></p>
    <!-- <p><strong>Medical History: </strong><br> <?= nl2br(htmlspecialchars($item['medical_history'] ?? 'N/A')) ?></p> -->
    <p><strong>Registered at: </strong> <?= htmlspecialchars($item['created_at'] ?? '-') ?></p>
  </div>

  <div class="profile-actions">
    <?php if (!empty($item['id'])): ?>
      <a href="/patients/edit/<?= urlencode((string)$item['id']) ?>" class="btn">Edit</a>
    <?php endif; ?>
    <a href="/patients" class="btn btn-secondary">Back</a>
  </div>
</div>

<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
