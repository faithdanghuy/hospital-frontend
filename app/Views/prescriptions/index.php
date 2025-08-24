<?php use App\Core\Auth; ?>
<?php ob_start(); ?>
<div class="header-actions">
  <h1>Prescriptions</h1>
  <?php if (Auth::role() === 'doctor'): ?>
  <a class="btn" href="/prescriptions/create">+ New</a>
  <?php endif; ?>
</div>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Patient_id</th>
      <th>Doctor_id</th>
      <th>Medication_id</th>
      <th>Quantity</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach (($items ?? []) as $it): ?>
    <tr>
      <td>{{ htmlspecialchars($it['id'] ?? '') }}</td>
      <td>{{ htmlspecialchars($it['patient_id'] ?? '') }}</td>
      <td>{{ htmlspecialchars($it['doctor_id'] ?? '') }}</td>
      <td>{{ htmlspecialchars($it['drug_id'] ?? '') }}</td>
      <td>{{ htmlspecialchars($it['quantity'] ?? '') }}</td>
      <td>{{ htmlspecialchars($it['status'] ?? '') }}</td>
      <td>
        <a href="/prescriptions/show/{{ urlencode($it['id']) }}">View</a>
        <a href="/prescriptions/edit/{{ urlencode($it['id']) }}">Edit</a>
        <form method="post" action="/prescriptions/delete/{{ urlencode($it['id']) }}" style="display:inline" onsubmit="return confirm('Delete?')">
          <input type="hidden" name="_csrf" value="{{ htmlspecialchars($_SESSION['csrf_token']) }}">
          <button type="submit">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>
