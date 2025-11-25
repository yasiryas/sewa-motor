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
// 1️⃣ LINE CHART — Monthly Booking (6 Bulan Terakhir)
// ===================================================
const areaCanvas = document.getElementById("myAreaChart");

if (areaCanvas) {
  fetch(BASE_URL + '/dashboard/monthly-bookings')
    .then(response => response.json())
    .then(data => {

      // Convert objek → array label
      const labels = Object.keys(data).map(m => {
        const date = new Date(m + "-01");
        return date.toLocaleString('default', { month: 'short', year: '2-digit' });
      });

      // Ambil angkanya
      const monthlyData = Object.values(data);

      new Chart(areaCanvas, {
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
            xAxes: [{
              gridLines: { display: false }
            }],
            yAxes: [{
              ticks: {
                beginAtZero: true,
                callback: value => number_format(value)
              }
            }]
          },
          legend: { display: false }
        }
      });
    });
}



// ===================================================
// 2️⃣ PIE CHART — Top 5 Motor Dengan Booking Terbanyak
// ===================================================
fetch(BASE_URL + "/dashboard/top-motors")
  .then(res => res.json())
  .then(data => {

    const labels = data.labels;   // <-- sudah benar
    const total = data.values;    // <-- sudah benar

    const ctx = document.getElementById("motorPieChart");

    new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: labels,
        datasets: [{
          data: total,
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

  // =============================
// BAR CHART - STATUS BOOKING
// =============================
fetch(BASE_URL + "/dashboard/booking-status")
    .then(res => res.json())
    .then(res => {

        document.getElementById("completedPercent").textContent = res.completed + "%";
        document.getElementById("pendingPercent").textContent   = res.pending + "%";
        document.getElementById("canceledPercent").textContent  = res.canceled + "%";

        document.getElementById("completedBar").style.width = res.completed + "%";
        document.getElementById("pendingBar").style.width   = res.pending + "%";
        document.getElementById("canceledBar").style.width  = res.canceled + "%";
    });



