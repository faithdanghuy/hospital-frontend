<?php use App\Core\Auth; ?>
<?php ob_start(); ?>
<div class="header-actions">
  <h1>Prescriptions</h1>
  <?php if (Auth::role() === 'doctor' || Auth::role() === 'admin'): ?>
    <a class="btn" href="/prescription/create">+ New</a>
  <?php endif; ?>
</div>

<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>Patient</th>
      <th>Doctor</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php $stt = 1; ?>
    <?php foreach (($items ?? []) as $it): ?>
    <?php 
      $status = strtolower($it['status'] ?? '-'); 
      $statusClass = '';
      switch ($status) {
        case 'not_collected':   $statusClass = 'badge-not-collected'; break;
        case 'collected':       $statusClass = 'badge-collected'; break;
      }
    ?>
    <tr>
      <td><?= htmlspecialchars($stt++) ?></td>
      <td><?= htmlspecialchars($it['patient']['full_name'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['doctor']['full_name'] ?? '-') ?></td>
      <?php
        $statusText = '-';
        switch ($status) {
          case 'not_collected': $statusText = 'Not Collected'; break;
          case 'collected':     $statusText = 'Collected'; break;
          default: $statusText = htmlspecialchars($it['status'] ?? '-');
        }
      ?>
      <td><span class="badge <?= $statusClass ?>"><?= $statusText ?></span></td>
      <td>
        <a href="/prescription/detail/<?= urlencode($it['id']) ?>" class="btn">View</a>
        <a href="/prescription/edit/<?= urlencode($it['id']) ?>" class="btn">Edit</a>
        <form method="post" action="/prescriptions/delete/<?= urlencode($it['id']) ?>" style="display:inline" onsubmit="return confirm('Delete?')">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
          <button type="submit" class="delete-btn"><i class="fas fa-trash"></i></button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
