<?php ob_start(); ?>
<div class="header-actions">
  <h1>Users</h1>
  <span> Total rows: <strong><?= $total_rows ?></strong></span>
  <form method="get" action="/account" class="role-filter-form">
    <select name="role" id="role-filter" onchange="this.form.submit()">
      <option value="" disabled selected>Select role</option>
      <option value="">All</option>
      <option value="admin"   <?= ($role ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
      <option value="doctor"  <?= ($role ?? '') === 'doctor' ? 'selected' : '' ?>>Doctor</option>
      <option value="patient" <?= ($role ?? '') === 'patient' ? 'selected' : '' ?>>Patient</option>
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
      <td><?= htmlspecialchars($it['full_name'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['email'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['phone'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['gender'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['role'] ?? '-') ?></td>
      
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
<?php if ($total_pages > 1): ?>
  <nav class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a class="page-link <?= $i == $page ? 'active' : '' ?>"
         href="/account?page=<?= $i ?>&limit=<?= $limit ?>&role=<?= urlencode($role) ?>">
        <?= $i ?>
      </a>
    <?php endfor; ?>
  </nav>
<?php endif; ?>

<?php $content = ob_get_clean(); 
echo App\Core\View::render('partials/layout', compact('content')); 
?>
