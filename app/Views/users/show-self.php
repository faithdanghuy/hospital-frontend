<?php
$name   = $item['full_name'] ?? 'Unknown';
$avatar = !empty($item['avatar'])
    ? $item['avatar']
    : 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=007bff&color=fff&size=128';
?>

<?php ob_start(); ?>
<div class="profile-container">
  <div class="profile-card">
    <div class="profile-header">
      <img class="avatar" src="<?= htmlspecialchars($avatar, ENT_QUOTES, 'UTF-8') ?>" alt="Avatar">
      <h2 class="profile-name"><?= htmlspecialchars($name) ?></h2>
      <p class="profile-id">ID: <?= htmlspecialchars($item['id'] ?? '-') ?></p>
    </div>

    <div class="profile-details">
      <p><strong>Role:</strong> <?= htmlspecialchars($item['role'] ?? '-') ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($item['email'] ?? '-') ?></p>
      <p><strong>Date of Birth:</strong> 
          <?php 
              if (!empty($item['birthday'])) {
                  $dob = new DateTime($item['birthday']);
                  echo $dob->format('d/m/Y');
              } else {
                  echo '-';
              }
          ?>
      </p>
      <p><strong>Gender:</strong> <?= htmlspecialchars($item['gender'] ?? '-') ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($item['phone'] ?? '-') ?></p>
      <p><strong>Address:</strong> <?= htmlspecialchars($item['address'] ?? '-') ?></p>
      <div class="divider"></div>

      <p><strong>Medical History:</strong> - </p>
    </div>

    <div class="profile-actions">
        <a href="/account/edit" class="btn">Edit Profile</a>
        <a href="/account/change-password" class="btn">Change Password</a>
        <a href="/account" class="btn btn-secondary">Back</a>
    </div>
  </div>
</div>

<?php 
$content = ob_get_clean(); 
echo App\Core\View::render('partials/layout', compact('content')); 
?>
