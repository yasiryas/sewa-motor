// ===================================================
// SB Admin 2 Default Font
// ===================================================
Chart.defaults.global.defaultFontFamily =
  'Nunito, -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// ===================================================
// Number Format Helper
// ===================================================
function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(',', '').replace(' ', '');
  var n = isFinite(+number) ? +number : 0,
      prec = isFinite(+decimals) ? Math.abs(decimals) : 0,
      sep = thousands_sep || ',',
      dec = dec_point || '.',
      s = '',
      toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
      };
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// ===================================================
// Realtime polling (AJAX pool)
// Kartu statistik & progress status di-refresh tiap 15 detik,
// grafik (booking bulanan & top motor) tiap 60 detik.
// ===================================================
var STAT_REFRESH_MS = 15000;
var CHART_REFRESH_MS = 60000;

var monthlyChart = null;
var topMotorsChart = null;

function markSynced() {
  var el = document.getElementById("lastSync");
  if (el) el.textContent = new Date().toLocaleTimeString('id-ID');
}

// ===================================================
// Kartu statistik (pending, users, motors, revenue)
// ===================================================
function loadStats() {
  fetch(BASE_URL + '/dashboard/stats')
    .then(function (res) { if (!res.ok) throw res; return res.json(); })
    .then(function (data) {
      var pending = document.getElementById("statPendingRequests");
      var users = document.getElementById("statTotalUsers");
      var motors = document.getElementById("statTotalMotors");
      var revenue = document.getElementById("statMonthlyRevenue");

      if (pending) pending.textContent = data.pending_requests;
      if (users) users.textContent = data.total_users;
      if (motors) motors.textContent = data.total_motors;
      if (revenue) revenue.textContent = 'Rp. ' + number_format(data.monthly_revenue, 0, ',', '.');

      markSynced();
    })
    .catch(function () { /* biarkan nilai lama saat request gagal */ });
}

// ===================================================
// 1️⃣ LINE CHART — Monthly Booking (6 Bulan Terakhir)
// ===================================================
function loadMonthlyBookings() {
  var areaCanvas = document.getElementById("myAreaChart");
  if (!areaCanvas) return;

  fetch(BASE_URL + '/dashboard/monthly-bookings')
    .then(function (res) { return res.json(); })
    .then(function (data) {
      var labels = Object.keys(data).map(function (m) {
        var date = new Date(m + "-01");
        return date.toLocaleString('default', { month: 'short', year: '2-digit' });
      });
      var monthlyData = Object.values(data);

      if (monthlyChart) monthlyChart.destroy();

      monthlyChart = new Chart(areaCanvas, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: "Total Booking",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: monthlyData,
          }],
        },
        options: {
          maintainAspectRatio: false,
          scales: {
            xAxes: [{ gridLines: { display: false } }],
            yAxes: [{
              ticks: {
                beginAtZero: true,
                callback: function (value) { return number_format(value); }
              }
            }]
          },
          legend: { display: false }
        }
      });
    });
}

// ===================================================
// 2️⃣ DOUGHNUT CHART — Top 5 Motor Dengan Booking Terbanyak
// ===================================================
function loadTopMotors() {
  var ctx = document.getElementById("motorPieChart");
  if (!ctx) return;

  fetch(BASE_URL + "/dashboard/top-motors")
    .then(function (res) { return res.json(); })
    .then(function (data) {
      if (topMotorsChart) topMotorsChart.destroy();

      topMotorsChart = new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: data.labels,
          datasets: [{
            data: data.values,
            backgroundColor: [
              "#4e73df",
              "#1cc88a",
              "#36b9cc",
              "#f6c23e",
              "#e74a3b"
            ],
            hoverBackgroundColor: [
              "#2e59d9",
              "#17a673",
              "#2c9faf",
              "#dda20a",
              "#be2617"
            ]
          }]
        },
        options: {
          maintainAspectRatio: false,
          cutoutPercentage: 80,
          legend: { position: 'bottom' }
        }
      });
    });
}

// ===================================================
// 3️⃣ PROGRESS BAR — Status Booking Bulan Ini
// ===================================================
function loadBookingStatus() {
  var completedPercent = document.getElementById("completedPercent");
  if (!completedPercent) return;

  fetch(BASE_URL + "/dashboard/booking-status")
    .then(function (res) { return res.json(); })
    .then(function (res) {
      completedPercent.textContent = res.completed + "%";
      document.getElementById("pendingPercent").textContent = res.pending + "%";
      document.getElementById("canceledPercent").textContent = res.canceled + "%";

      document.getElementById("completedBar").style.width = res.completed + "%";
      document.getElementById("pendingBar").style.width = res.pending + "%";
      document.getElementById("canceledBar").style.width = res.canceled + "%";
    });
}

// Muat pertama kali
loadStats();
loadMonthlyBookings();
loadTopMotors();
loadBookingStatus();

// AJAX pool: polling berkala agar dashboard realtime
setInterval(loadStats, STAT_REFRESH_MS);
setInterval(loadBookingStatus, STAT_REFRESH_MS);
setInterval(loadMonthlyBookings, CHART_REFRESH_MS);
setInterval(loadTopMotors, CHART_REFRESH_MS);
