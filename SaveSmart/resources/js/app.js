import { Chart } from "@/components/ui/chart"
// Fonction pour formater les montants en euros
function formatCurrency(amount) {
  return new Intl.NumberFormat("fr-FR", { style: "currency", currency: "EUR" }).format(amount)
}

// Fonction pour calculer le pourcentage
function calculatePercentage(value, total) {
  return total > 0 ? ((value / total) * 100).toFixed(2) : 0
}

// Gestionnaire d'événements pour les formulaires de confirmation
document.addEventListener("DOMContentLoaded", () => {
  const confirmForms = document.querySelectorAll("form[data-confirm]")
  confirmForms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      if (!confirm(this.dataset.confirm)) {
        e.preventDefault()
      }
    })
  })
})

// Fonction pour le menu déroulant responsive
function toggleMenu() {
  const menu = document.getElementById("mobile-menu")
  if (menu) {
    menu.classList.toggle("hidden")
  }
}

// Exemple de fonction pour créer un graphique simple (à adapter selon vos besoins)
function createSimpleChart(elementId, data) {
  const ctx = document.getElementById(elementId).getContext("2d")
  new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: data.map((item) => item.category),
      datasets: [
        {
          data: data.map((item) => item.amount),
          backgroundColor: data.map((item) => item.color),
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        position: "bottom",
      },
    },
  })
}

// Fonction pour mettre à jour la barre de progression
function updateProgressBar(elementId, current, target) {
  const progressBar = document.getElementById(elementId)
  if (progressBar) {
    const percentage = calculatePercentage(current, target)
    progressBar.style.width = percentage + "%"
    progressBar.textContent = percentage + "%"
  }
}

