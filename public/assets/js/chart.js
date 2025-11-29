$(function() {
  /* ChartJS
   * -------
   * Data and config for chartjs
   */
  'use strict';

  // --- 1. DEFINISI OPTIONS (WAJIB ADA) ---
  // Ini konfigurasi tampilan (garis grid, legend, dll) dari template asli Anda.
  var options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        },
        gridLines: {
          color: "rgba(204, 204, 204,0.1)"
        }
      }],
      xAxes: [{
        gridLines: {
          color: "rgba(204, 204, 204,0.1)"
        }
      }]
    },
    legend: {
      display: false
    },
    elements: {
      line: {
        tension: 0.5,
      },
      point: {
        radius: 4 // Saya ubah ke 4 agar titiknya terlihat
      }
    }
  };

  // --- 2. DATA DINAMIS (DARI BLADE) ---
  // Cek apakah variabel global dari Blade sudah ada.
  var labels = typeof monthlyLabels !== 'undefined' ? monthlyLabels : ["Jan", "Feb", "Mar", "Apr"];
  var visits = typeof monthlyVisits !== 'undefined' ? monthlyVisits : [10, 20, 15, 30];

  // --- 3. SUSUN DATA KHUSUS LINE CHART ---
  var monthlyVisitsData = {
    labels: labels,
    datasets: [{
      label: 'Total Visits',
      data: visits,
      backgroundColor: [
        'rgba(54, 162, 235, 0.2)'
      ],
      borderColor: [
        'rgba(54, 162, 235, 1)'
      ],
      borderWidth: 2,
      fill: true, // Ubah ke true jika ingin ada warna di bawah garis
      pointBorderColor: '#587ce4',
      pointBackgroundColor: '#ffffff', // Putih agar kontras
      pointRadius: 5,
    }]
  };

  // --- 4. INISIALISASI LINE CHART ---
  if ($("#lineChart").length) {
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: monthlyVisitsData, // Menggunakan data dinamis kita
      options: options         // Menggunakan options yang sudah didefinisikan di atas
    });
  }

});
