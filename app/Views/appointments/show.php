<?php use App\Core\Auth; ?>
<?php ob_start(); ?>
<div class="container">
  <h1 style="text-align: center;">Appointment Details</h1>

  <div class="card">
    <div class="card__body">
      <div class="field">
        <strong>Patient:</strong>
        <span class="field__value">
          <a href="../account/detail/<?= htmlspecialchars($item['patient']['id'] ?? '#'); ?>">
            <?= htmlspecialchars($item['patient']['full_name'] ?? 'N/A'); ?>
          </a>
        </span>
      </div>

  <div class="field">
    <strong>Doctor:</strong>
    <span class="field__value">
      <a href="../account/detail/<?= htmlspecialchars($item['doctor']['id'] ?? '#'); ?>">
      	<?= htmlspecialchars($item['doctor']['full_name'] ?? 'N/A'); ?>
      </a>
    </span>
  </div>

  <div class="field">
    <strong>Date:</strong>
    <span class="field__value">
      <?= htmlspecialchars($item['date'] ?? 'N/A'); ?>
    </span>
  </div>

  <div class="field">
    <strong>Time:</strong>
    <span class="field__value">
      <?= htmlspecialchars($item['time'] ?? 'N/A'); ?>
    </span>
  </div>

  <div class="field">
    <strong>Confirm at:</strong>
    <span class="field__value">
      <?= htmlspecialchars($item['confirmed_date'] ?? 'N/A'); ?> - 
    	<?= htmlspecialchars($item['confirmed_time'] ?? 'N/A'); ?>
  	</span>
  </div>

  <div class="field">
    <strong>Status:</strong>
    <span class="status <?= strtolower($item['status'] ?? 'pending'); ?>">
      <?= htmlspecialchars($item['status'] ?? 'Pending'); ?>
  	</span>
  </div>

  <?php if (!empty(trim((string)$item['note']))): ?>
  <div class="description">
  	<strong>Note:</strong> <?= nl2br(htmlspecialchars((string)$item['note'])); ?>
  </div>
  <?php endif; ?>

  <div style="margin-top: 20px; text-align: center;">
    <a class="btn" href="/appointment/edit/<?= urlencode((string)($item['id'] ?? '')) ?>">Edit Appointment</a>

    <?php if (Auth::role() === 'doctor' || Auth::role() === 'admin'): ?>
      <?php if ($item['status'] === 'pending'): ?>
        <form method="post" action="/appointment/change-status/<?= htmlspecialchars($item['id'] ?? ''); ?>" style="display:inline-block;">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
          <input type="hidden" name="status" value="confirmed">
          <button type="submit" class="btn success">Confirm</button>
      	</form>
        
        <form method="post" action="/appointment/change-status/<?= htmlspecialchars($item['id'] ?? ''); ?>" style="display:inline-block;">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
          <input type="hidden" name="status" value="cancelled">
          <button type="submit" class="btn danger">Cancel</button>
        </form>
        
      <?php elseif ($item['status'] === 'confirmed'): ?>
        <form method="post" action="/appointment/change-status/<?= htmlspecialchars($item['id'] ?? ''); ?>" style="display:inline-block;">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
          <input type="hidden" name="status" value="cancelled">
          <button type="submit" class="btn danger">Cancel</button>
        </form>
        
      <?php elseif ($item['status'] === 'cancelled'): ?>
        <form method="post" action="/appointment/change-status/<?= htmlspecialchars($item['id'] ?? ''); ?>" style="display:inline-block;">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
          <input type="hidden" name="status" value="confirmed">
          <button type="submit" class="btn success">Confirm</button>
        </form>
      <?php endif; ?>
  	<?php endif; ?>
  </div>
</div>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
