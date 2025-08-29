<?php ob_start(); ?>
<div class="header-actions">
  <h1>Notifications</h1>
</div>

<div class="notifications-list">
  <?php foreach ($items as $it): 
      $isRead = !empty($it['is_read']);
  ?>
    <div class="notification-card <?= $isRead ? 'read' : 'unread' ?>">
      <h3><?= htmlspecialchars($it['title']) ?></h3>
      <p><?= htmlspecialchars($it['body']) ?></p>

      <div class="actions">
        <?php if (!$isRead): ?>
          <form method="delete" action="/notifications/delete/<?= urlencode($it['id']) ?>" style="display:inline">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <button type="submit" class="delete-btn">Delete</button>
          </form>

          <form method="post" action="/notifications/mark-read/<?= urlencode($it['id']) ?>" style="display:inline">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <button type="submit" class="btn">Mark as read ✅</button>
          </form>
        <?php else: ?>
          <form method="delete" action="/notifications/delete/<?= urlencode($it['id']) ?>" style="display:inline">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <button type="submit" class="delete-btn">Delete</button>
          </form>
          <span class="read-indicator">✓ Read</span>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php 
$content = ob_get_clean(); 
echo App\Core\View::render('partials/layout', compact('content')); 
?>
