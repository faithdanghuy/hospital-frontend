<?php ob_start(); ?>
<div class="header-actions">
  <h1>Appointments</h1>
  <a class="btn" href="/appointments/create">+ New</a>
</div>

<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>Date</th>
      <th>Time</th>
      <th>Doctor</th>
      <th>Patient</th>
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
        case 'pending':   $statusClass = 'badge-pending'; break;
        case 'confirmed': $statusClass = 'badge-confirmed'; break;
        case 'cancelled': $statusClass = 'badge-cancelled'; break;
      }
    ?>
    <tr>
      <td><?= htmlspecialchars($stt++) ?></td>
      <td><?= htmlspecialchars($it['date'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['time'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['doctor']['full_name'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['patient']['full_name'] ?? '-') ?></td>
      <td><span class="badge <?= $statusClass ?>"><?= htmlspecialchars($it['status'] ?? '-') ?></span></td>

      <td class="actions">
        <a class="btn" href="/appointment/<?= urlencode($it['id']) ?>">View</a>
        <a class="btn" href="/appointment/edit/<?= urlencode($it['id']) ?>">Edit</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
