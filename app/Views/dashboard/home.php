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
        <p class="number"><?= array_sum($patient_stats['values'] ?? []) ?></p>
        <a href="/accounts" class="btn-link">View</a>
      </div>
      <div class="card summary">
        <h3>Appointments</h3>
        <p class="number"><?= array_sum($appointment_stats['values'] ?? []) ?></p>
        <a href="/appointments" class="btn-link">View</a>
      </div>
      <div class="card summary">
        <h3>Prescriptions</h3>
        <p class="number"><?= array_sum($prescription_stats['values'] ?? []) ?></p>
        <a href="/prescriptions" class="btn-link">View</a>
      </div>
    </div>

    <!-- Reports Section -->
    <div class="reports">
      <h2>Quick Report</h2>
      <select id="chartType">
        <option value="patients">Patients</option>
        <option value="appointments">Appointments</option>
        <option value="prescriptions">Prescriptions</option>
      </select>
      <div style="height:300px; display:flex; justify-content:center; align-items:center;">
        <canvas id="dashboardChart"></canvas>
      </div>
    </div>

    <?php elseif ($role === 'patient' || $role === 'doctor'): ?>
      <div class="dashboard-grid">
        <div class="card summary">
          <h3>My Appointments</h3>
          <p class="number"><?= $total_app ?? 0 ?></p>
          <a href="/appointments" class="btn-link">View</a>
        </div>
        <div class="card summary">
          <h3>My Prescriptions</h3>
          <p class="number"><?= $total_pre ?? 0 ?></p>
          <a href="/prescriptions" class="btn-link">View</a>
        </div>
      </div>
    
      <div class="calendar-section" style="margin-top:20px;">
        <h2>Appointments Calendar</h2>
        <div id="calendar"></div>
      </div>
    <?php endif; ?>
<?php endif; ?>

<?php $content = ob_get_clean(); echo App\Core\View::render('partials/layout', compact('content')); ?>

<!-- Add Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
<?php if ($role === 'admin'): ?>
// Chuẩn bị datasets từ PHP
const datasets = {
  patients: {
    labels: <?= json_encode($patient_stats['labels'] ?? []) ?>,
    values: <?= json_encode($patient_stats['values'] ?? []) ?>
  },
  appointments: {
    labels: <?= json_encode($appointment_stats['labels'] ?? []) ?>,
    values: <?= json_encode($appointment_stats['values'] ?? []) ?>
  },
  prescriptions: {
    labels: <?= json_encode($prescription_stats['labels'] ?? []) ?>,
    values: <?= json_encode($prescription_stats['values'] ?? []) ?>
  }
};

const ctx = document.getElementById('dashboardChart').getContext('2d');

// Hàm tạo chart
function createChart(type) {
  if (window.currentChart) {
    window.currentChart.destroy();
  }

  const data = datasets[type];
  window.currentChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: data.labels,
      datasets: [{
        label: `${type.charAt(0).toUpperCase() + type.slice(1)} Registered (per day)`,
        data: data.values,
        backgroundColor: 'rgba(79, 70, 229, 0.6)',
        borderColor: '#4F46E5',
        fill: true,
        borderWidth: 2,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { 
          beginAtZero: true,
          ticks: { stepSize: 1 }
        }
      }
    }
  });
}

// Khởi tạo chart mặc định (patients)
createChart('patients');

// Lắng nghe khi đổi select
document.getElementById('chartType').addEventListener('change', function() {
  createChart(this.value);
});
<?php endif; ?>

<?php if ($role === 'patient'): ?>
document.addEventListener('DOMContentLoaded', function() {
  const calendarEl = document.getElementById('calendar');
  if (!calendarEl) return;

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    height: 600,
    events: <?= json_encode(array_map(function($a) {
      return [
        'id'    => $a['id'],
        'start' => $a['scheduled_at'],
        'color' => $a['status'] === 'cancelled' ? '#f87171' : '#4ade80'
      ];
    }, $app ?? [])) ?>,
    eventClick: function(info) {
      alert(
        "Patient: " + info.event.title +
        "\nDate: " + info.event.start.toLocaleString() +
        "\nStatus: " + (info.event.backgroundColor === '#f87171' ? "Cancelled" : "Scheduled")
      );
    }
  });

  calendar.render();
});
<?php endif; ?>
</script>