document.addEventListener("DOMContentLoaded", function () {
  const canvas = document.getElementById("caloriesChart");
  const jours = JSON.parse(canvas.dataset.jours);
  const calories = JSON.parse(canvas.dataset.calories);
  const objectif = parseInt(canvas.dataset.objectif);

  new Chart(canvas, {
    type: "line",
    data: {
      labels: jours,
      datasets: [
        {
          label: "Calories consommées",
          data: calories,
          borderColor: "#e8a020",
          backgroundColor: "rgba(232,160,32,0.12)",
          fill: true,
          tension: 0.4,
          pointBackgroundColor: "#e8a020",
          pointBorderColor: "#0e0e0e",
          pointBorderWidth: 2,
          pointRadius: 5,
          pointHoverRadius: 7,
        },
        {
          label: "Objectif calorique",
          data: Array(7).fill(objectif),
          borderColor: "rgba(240,236,228,0.25)",
          borderDash: [6, 4],
          pointRadius: 0,
          tension: 0,
          fill: false,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          labels: {
            color: "rgba(240,236,228,0.7)",
            font: { family: "Outfit", size: 13 },
            boxWidth: 12,
            padding: 20,
          },
        },
        tooltip: {
          backgroundColor: "rgba(14,14,14,0.92)",
          borderColor: "rgba(232,160,32,0.4)",
          borderWidth: 1,
          titleColor: "#e8a020",
          bodyColor: "#f0ece4",
          padding: 12,
          titleFont: { family: "Outfit", weight: "600" },
          bodyFont: { family: "Outfit" },
          callbacks: {
            label: (ctx) => ` ${ctx.parsed.y} kcal`,
          },
        },
      },
      scales: {
        x: {
          grid: { color: "rgba(255,255,255,0.05)" },
          ticks: {
            color: "rgba(240,236,228,0.55)",
            font: { family: "Outfit" },
          },
        },
        y: {
          grid: { color: "rgba(255,255,255,0.05)" },
          ticks: {
            color: "rgba(240,236,228,0.55)",
            font: { family: "Outfit" },
            callback: (v) => v + " kcal",
          },
        },
      },
    },
  });
});
