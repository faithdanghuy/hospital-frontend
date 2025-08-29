<?php
$prescriptionId = $item['id'] ?? '-';
$status = $item['status'] ?? '-';

$patient = $item['patient'] ?? [];
$doctor  = $item['doctor'] ?? [];
$medications = $item['medications'] ?? [];

$createdAt = !empty($item['created_at']) ? (new DateTime($item['created_at']))->format('d/m/Y H:i') : '-';
$updatedAt = !empty($item['updated_at']) ? (new DateTime($item['updated_at']))->format('d/m/Y H:i') : '-';
?>

<?php ob_start(); ?>
<div class="profile-container">
  <div class="profile-card">
    <div class="profile-header">
      <h2 class="profile-name">Prescription Detail</h2>
      <p class="profile-id">ID: <?= htmlspecialchars($prescriptionId) ?></p>
    </div>

    <div class="profile-details">
      <div class="status-row">
        <?php 
          $status = strtolower($item['status'] ?? '-'); 
          $statusText = '';
          switch ($status) {
            case 'not_collected':   $statusText = 'Not Collected'; break;
            case 'collected':       $statusText = 'Collected'; break;
        }
        ?>
        <strong>Status:</strong> 
        <span class="status <?= htmlspecialchars($item['status']) ?>">
          <?= $statusText ?>
        </span>
        <strong>Created At:</strong> <span><?= $createdAt ?></span>
        <strong>Updated At:</strong> <span><?= $updatedAt ?></span>
      </div>
      
      <div class="info-grid">
        <div class="info-card">
          <h3>Patient Info</h3>
          <p><strong>Name:</strong> <?= htmlspecialchars($patient['full_name'] ?? '-') ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($patient['email'] ?? '-') ?></p>
          <p><strong>Phone:</strong> <?= htmlspecialchars($patient['phone'] ?? '-') ?></p>
        </div>
        
        <div class="info-card">
          <h3>Doctor Info</h3>
          <p><strong>Name:</strong> <?= htmlspecialchars($doctor['full_name'] ?? '-') ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($doctor['email'] ?? '-') ?></p>
          <p><strong>Phone:</strong> <?= htmlspecialchars($doctor['phone'] ?? '-') ?></p>
        </div>
      </div>
      <div class="divider"></div>
      <h3>Medications</h3>
      <?php if (!empty($medications)): ?>
        <table class="table">
          <thead>
            <tr>
              <th>No.</th>
              <th>Issued At</th>
              <th>Quantity</th>
              <th>Dosage</th>
              <th>Instruction</th>
              <th>Medication ID</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($medications as $i => $med): ?>
              <tr>
                <td><?= $i+1 ?></td>
                <td>
                  <?php 
                    if (!empty($med['issued_at'])) {
                        $issued = new DateTime($med['issued_at']);
                        echo $issued->format('d/m/Y H:i');
                    } else {
                        echo '-';
                    }
                  ?>
                </td>
                <td><?= htmlspecialchars($med['quantity'] ?? '-') ?></td>
                <td><?= htmlspecialchars($med['dosage'] ?? '-') ?></td>
                <td><?= htmlspecialchars($med['instruction'] ?? '-') ?></td>
                <td><?= htmlspecialchars($med['medication_id'] ?? '-') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No medications found.</p>
      <?php endif; ?>
    </div>

    <div class="profile-actions">
        <a href="/prescriptions" class="btn btn-secondary">Back</a>
    </div>
  </div>
</div>

<?php 
$content = ob_get_clean(); 
echo App\Core\View::render('partials/layout', compact('content')); 
?>
