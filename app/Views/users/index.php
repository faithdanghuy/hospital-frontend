<?php ob_start(); ?>
<div class="header-actions">
  <h1>Users</h1>
  <form method="get" action="/account/filter" style="display:inline-flex; align-items:center; gap:0.5em; margin-right: 1em;">
    <label>Role</label>
    <select name="role" id="role-filter" onchange="this.form.submit()">
      <option value="">All</option>
      <option value="admin" <?= isset($_GET['role']) && $_GET['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
      <option value="doctor" <?= isset($_GET['role']) && $_GET['role'] === 'doctor' ? 'selected' : '' ?>>Doctor</option>
      <option value="patient" <?= isset($_GET['role']) && $_GET['role'] === 'patient' ? 'selected' : '' ?>>Patient</option>
    </select>
  </form>
  <a class="btn" href="/account/register">+ New User</a>
</div>

<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>Full Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Gender</th>
      <th>Role</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php $stt = ((($page ?? 1) - 1) * ($limit ?? 10)) + 1; ?>
    <?php foreach (($items ?? []) as $it): ?>
    <tr>
      <td><?= $stt++ ?></td>
      <td><?= htmlspecialchars($it['FullName'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['Email'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['Phone'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['Gender'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['Role'] ?? '-') ?></td>
      <td class="actions">
        <a href="/account/detail/<?= urlencode((string)($it['id'] ?? '')) ?>" class="btn">View</a>
        <a href="/account/edit/<?= urlencode((string)($it['id'] ?? '')) ?>" class="btn">Edit</a>

        <form method="post" action="/account/delete/<?= urlencode((string)($it['id'] ?? '')) ?>" style="display:inline" onsubmit="return confirm('Delete?')">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="delete-btn"><i class="fas fa-trash"></i></button>
        </form>

      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Pagination -->
<?php
$totalPages = ceil(($total ?? 0) / ($limit ?? 10));
if ($totalPages > 1): ?>
  <nav class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <a class="page-link <?= $i == ($page ?? 1) ? 'active' : '' ?>" href="/users?page=<?= $i ?>&limit=<?= $limit ?? 10 ?>">
        <?= $i ?>
      </a>
    <?php endfor; ?>
  </nav>
<?php endif; ?>

<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
