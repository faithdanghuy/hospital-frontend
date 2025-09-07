<?php
  $statusCycle = ['', 'pending', 'confirmed', 'cancelled']; 
  $currentIndex = array_search(strtolower($status ?? ''), $statusCycle);
  $nextIndex = ($currentIndex === false) ? 1 : ($currentIndex + 1) % count($statusCycle);
  $nextStatus = $statusCycle[$nextIndex];
?>

<?php ob_start(); ?>
<div class="header-actions">
  <h1>Appointments</h1>
  <span> Total rows: <strong><?= $total_rows ?></strong></span>
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
      <th>
        <a href="/appointments?page=<?= $page ?>&limit=<?= $limit ?>&status=<?= $nextStatus ?>">
          Status <?= $status ? '(' . ucfirst($status) . ')' : '(All)' ?>
        </a>
      </th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php $stt = ((($page ?? 1) - 1) * ($limit ?? 10)) + 1; ?>
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

<!-- Pagination -->
<?php if ($total_pages > 1): ?>
  <nav class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a class="page-link <?= $i == $page ? 'active' : '' ?>"
         href="/appointments?page=<?= $i ?>&limit=<?= $limit ?>">
        <?= $i ?>
      </a>
    <?php endfor; ?>
  </nav>
<?php endif; ?>

<?php $content = ob_get_clean(); 
echo App\Core\View::render('partials/layout', compact('content')); 
?>
