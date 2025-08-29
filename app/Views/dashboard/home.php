<?php use App\Core\Auth; ?>
<?php ob_start(); ?>
<h1>Dashboard</h1>

<?php if (Auth::check()): ?>
  <?php $role = Auth::role(); ?>
  <?php if ($role === 'admin'): ?>
    <div class="dashboard-grid">
    <!-- Summary Cards -->
      <div class="card summary">
        <h3>New Patients</h3>
        <p class="number"><?= $patient_stats['new'] ?? 0 ?></p>
        <a href="/accounts" class="btn-link">View</a>
      </div>
      <div class="card summary">
        <h3>Appointments</h3>
        <p class="number"><?= $appointment_stats['total'] ?? 0 ?></p>
        <a href="/appointments" class="btn-link">View</a>
      </div>
      <div class="card summary">
        <h3>Prescriptions</h3>
        <p class="number"><?= $prescription_stats['total'] ?? 0 ?></p>
        <a href="/prescriptions" class="btn-link">View</a>
      </div>
    </div>

    <!-- Reports Section -->
    <div class="reports">
      <h2>Quick Report</h2>
      <canvas id="patientsChart"></canvas>
    </div>

    <?php elseif ($role === 'doctor'): ?>
      <div class="dashboard-grid">
        <div class="card summary">
          <h3>Today's Appointments</h3>
          <p class="number"><?= $stats['appointments_today'] ?? 0 ?></p>
          <a href="/appointments" class="btn-link">View Schedule</a>
        </div>
        <div class="card summary">
          <h3>My Patients</h3>
          <p class="number"><?= $stats['my_patients'] ?? 0 ?></p>
          <a href="/patients" class="btn-link">View Patients</a>
        </div>
        <div class="card summary">
          <h3>Prescriptions</h3>
          <p class="number"><?= $stats['pending_prescriptions'] ?? 0 ?></p>
          <a href="/prescriptions" class="btn-link">Review</a>
        </div>
      </div>

    <?php elseif ($role === 'patient'): ?>
      <div class="dashboard-grid">
        <div class="card summary">
          <h3>Upcoming Appointments</h3>
          <p class="number"><?= $stats['appointments_upcoming'] ?? 0 ?></p>
          <a href="/appointments" class="btn-link">View</a>
        </div>
        <div class="card summary">
          <h3>My Prescriptions</h3>
          <p class="number"><?= $stats['prescriptions'] ?? 0 ?></p>
          <a href="/prescriptions" class="btn-link">View</a>
        </div>
        <div class="card summary">
          <h3>Medical History</h3>
          <p class="number"><?= $stats['visits'] ?? 0 ?></p>
          <a href="/reports" class="btn-link">View</a>
        </div>
      </div>
    <?php endif; ?>
<?php endif; ?>

<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>

<!-- Add Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
<?php if ($role === 'admin'): ?>
const ctx = document.getElementById('patientsChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($chart['labels'] ?? []) ?>,
    datasets: [{
      label: 'Patients Registered (per day)',
      data: <?= json_encode($chart['values'] ?? []) ?>,
      backgroundColor: 'rgba(79, 70, 229, 0.6)',
      borderColor: '#4F46E5',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: { beginAtZero: true }
    },
    plugins: {
      legend: { display: true }
    }
  }
});
<?php endif; ?>
</script>