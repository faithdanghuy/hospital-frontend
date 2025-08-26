<?php ob_start(); ?>
<div class="header-actions">
  <h1>Appointments</h1>
  <a class="btn" href="/appointments/create">+ New</a>
</div>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Doctor id</th>
      <th>Time</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach (($items ?? []) as $it): ?>
    <tr>
      <td><?= htmlspecialchars($it['id'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['patient_id'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['doctor_id'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['time'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['status'] ?? '-') ?></td>
      <td>
        <a href="/appointments/<?= urlencode($it['id']) ?>">View</a>
        <a href="/appointments/edit/<?= urlencode($it['id']) ?>">Edit</a>
        <form method="post" action="/appointments/delete/<?= urlencode($it['id']) ?>" style="display:inline" onsubmit="return confirm('Delete?')">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
          <button type="submit">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
