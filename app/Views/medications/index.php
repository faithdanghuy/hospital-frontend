<?php ob_start(); ?>
<div class="header-actions">
  <h1>Medication</h1>
  <a class="btn" href="/medications/create">+ New</a>
</div>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Stock</th>
      <th>Unit</th>
      <th>Price</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach (($items ?? []) as $it): ?>
    <tr>
      <td><?= htmlspecialchars($it['id'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['name'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['stock'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['unit'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['price'] ?? '-') ?></td>
      <td>
        <a href="/medications/show/<?= urlencode($it['id']) ?>">View</a>
        <a href="/medications/edit/<?= urlencode($it['id']) ?>">Edit</a>
        <form method="post" action="/medications/delete/<?= urlencode($it['id']) ?>" style="display:inline" onsubmit="return confirm('Delete?')">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
          <button type="submit">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
