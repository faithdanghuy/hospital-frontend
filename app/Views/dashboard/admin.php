<?php ob_start(); ?>
<h1>Admin Dashboard</h1>

<div class="dashboard-grid">
  <!-- Summary Cards -->
  <div class="card summary">
    <h3>Users</h3>
    <p class="number"><?= $stats['users'] ?? 0 ?></p>
    <a href="/accounts" class="btn-link">View</a>
  </div>
  <div class="card summary">
    <h3>Medications</h3>
    <p class="number"><?= $stats['medications'] ?? 0 ?></p>
    <a href="/medications" class="btn-link">View</a>
  </div>
  <div class="card summary">
    <h3>Appointments</h3>
    <p class="number"><?= $stats['appointments'] ?? 0 ?></p>
    <a href="/appointments" class="btn-link">View</a>
  </div>
  <div class="card summary">
    <h3>Prescriptions</h3>
    <p class="number"><?= $stats['prescriptions'] ?? 0 ?></p>
    <a href="/prescriptions" class="btn-link">View</a>
  </div>
</div>

<!-- Reports Section -->
<div class="reports">
  <h2>Quick Report</h2>
  <canvas id="patientsChart"></canvas>
</div>

<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>

<!-- Add Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('patientsChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chart['labels'] ?? ["Jan","Feb","Mar","Apr"]) ?>,
        datasets: [{
            label: 'Patients Registered',
            data: <?= json_encode($chart['data'] ?? [5,10,7,12]) ?>,
            borderColor: '#4F46E5',
            fill: false,
            tension: 0.2
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: true } }
    }
});