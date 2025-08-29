<?php ob_start(); ?>
<div class="header-actions">
  <h1>Medication</h1>
  <a class="btn" href="/medication/create">+ New</a>
</div>

<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>Name</th>
      <th>Stock</th>
      <th>Unit</th>
      <th>Price</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php $stt = 1; ?>
    <?php foreach (($items ?? []) as $it): ?>
    <tr>
      <td><?= htmlspecialchars($stt++) ?></td>
      <td><?= htmlspecialchars($it['drug_name'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['stock'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['unit'] ?? '-') ?></td>
      <td><?= htmlspecialchars($it['price'] ?? '-') ?></td>
      <td>
        <a class="btn "href="/medication/detail/<?= urlencode($it['id']) ?>">View</a>
        <a class="btn" href="/medication/edit/<?= urlencode($it['id']) ?>">Edit</a>
        <form method="post" action="/medication/delete/<?= urlencode($it['id']) ?>" style="display:inline" onsubmit="return confirm('Delete?')">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
          <button type="submit" class="btn delete-btn"><i class="fas fa-trash"></i></button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
