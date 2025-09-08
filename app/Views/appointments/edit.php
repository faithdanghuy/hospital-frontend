<?php use App\Core\Auth; ?>
<?php ob_start(); ?>
<div class="container">
  <h1 style="text-align: center;">Edit Appointment</h1>

  <!-- Error handling -->
  <?php if (!empty($error)): ?>
    <div class="error-message" style="color: red; margin-bottom: 10px;">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <form method="POST" class="form" id="appointmentForm">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

    <div class="form-group">
      <label>Date</label>
      <input type="date" id="date" name="date" value="<?= htmlspecialchars($item['date'] ?? ''); ?>" required>
    </div>

    <div class="form-group">
      <label>Time</label>
      <input type="time" id="time" name="time" value="<?= htmlspecialchars($item['time'] ?? ''); ?>" required>
    </div>

    <input type="hidden" name="scheduled_at" id="scheduled_at" required>

    <div class="form-group">
      <label>Note</label>
      <input type="text" id="note" name="note" value="<?= htmlspecialchars($item['note'] ?? ''); ?>" required>
    </div>

    <?php if (Auth::role() === 'doctor' || Auth::role() === 'admin'): ?>
    <div class="form-group">
      <label>Status</label>
      <select id="status" name="status" required>
        <?php 
          $statuses = ['pending', 'confirmed', 'cancelled'];
          $currentStatus = $item['status'] ?? 'pending';
          foreach ($statuses as $status): ?>
            <option value="<?= $status ?>" <?= ($status === $currentStatus) ? 'selected' : '' ?>>
              <?= $status ?>
            </option>
          <?php endforeach; ?>
      </select>
    </div>
    <?php endif; ?>

    <button type="submit" class="btn">Save</button>
  </form>

  <script>
  document.getElementById("appointmentForm").addEventListener("submit", function() {
    const date = document.getElementById("date").value; // YYYY-MM-DD
    const time = document.getElementById("time").value; // HH:MM
    if (date && time) {
    	const isoString = date + "T" + time + ":00Z";
      document.getElementById("scheduled_at").value = isoString;
    }
  });
  </script>
</div>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
