<?php 
$items = [
    [
        'id' => 1,
        'title' => 'Upcoming Appointment',
        'message' => 'Your appointment with Dr. Smith is scheduled for tomorrow at 10:00 AM.',
        'is_read' => false
    ],
    [
        'id' => 2,
        'title' => 'Prescription Ready',
        'message' => 'Your prescription is ready for pickup at the pharmacy.',
        'is_read' => true
    ],
    [
        'id' => 3,
        'title' => 'Lab Results Available',
        'message' => 'Your recent blood test results are now available.',
        'is_read' => false
    ],
    [
        'id' => 4,
        'title' => 'Appointment Cancelled',
        'message' => 'Your appointment on 28/08 has been cancelled.',
        'is_read' => true
    ],
];
?>

<?php ob_start(); ?>
<h1>Notifications</h1>

<div class="notifications-list">
  <?php foreach ($items as $it): 
      $isRead = !empty($it['is_read']);
  ?>
    <div class="notification-card <?= $isRead ? 'read' : 'unread' ?>">
      <h3><?= htmlspecialchars($it['title']) ?></h3>
      <p><?= htmlspecialchars($it['message']) ?></p>

      <div class="actions">
        <?php if (!$isRead): ?>
          <form method="post" action="/notifications/mark-read/<?= urlencode($it['id']) ?>" style="display:inline">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <button type="submit" class="btn">Mark as read ✅</button>
          </form>
        <?php else: ?>
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
