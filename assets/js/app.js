// Main Application Logic
document.addEventListener("DOMContentLoaded", () => {
  initializeApp()
})

function initializeApp() {
  setupNavigation()
  setupFormHandlers()
  updateDateTime()

  // Update time every minute
  setInterval(updateDateTime, 60000)
}

function setupNavigation() {
  const navButtons = document.querySelectorAll(".nav-btn[data-section]")

  navButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault()
      const section = this.dataset.section
      showSection(section)
    })
  })
}

function showSection(sectionName) {
  // Hide all sections
  document.querySelectorAll(".section").forEach((section) => {
    section.classList.remove("active")
  })

  // Show selected section
  const targetSection = document.getElementById(sectionName)
  if (targetSection) {
    targetSection.classList.add("active")
  }

  // Update navigation
  document.querySelectorAll(".nav-btn").forEach((btn) => {
    btn.classList.remove("active")
  })

  const activeBtn = document.querySelector(`[data-section="${sectionName}"]`)
  if (activeBtn) {
    activeBtn.classList.add("active")
  }

  // Update URL without page reload
  if (history.pushState) {
    const newUrl =
      window.location.protocol + "//" + window.location.host + window.location.pathname + "?section=" + sectionName
    window.history.pushState({ path: newUrl }, "", newUrl)
  }
}

function setupFormHandlers() {
  // Handle form submissions with loading states
  const forms = document.querySelectorAll("form")

  forms.forEach((form) => {
    form.addEventListener("submit", (e) => {
      const submitBtn = form.querySelector('button[type="submit"]')
      if (submitBtn) {
        submitBtn.disabled = true
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...'
      }
    })
  })
}

function updateDateTime() {
  const now = new Date()
  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  }

  const dateTimeElements = document.querySelectorAll(".current-datetime")
  dateTimeElements.forEach((element) => {
    element.textContent = now.toLocaleDateString("id-ID", options)
  })
}

// Utility functions
function formatNumber(num, decimals = 0) {
  return new Intl.NumberFormat("id-ID", {
    minimumFractionDigits: decimals,
    maximumFractionDigits: decimals,
  }).format(num)
}

function showNotification(message, type = "info") {
  const notification = document.createElement("div")
  notification.className = `notification notification-${type}`
  notification.innerHTML = `
        <i class="fas fa-${type === "success" ? "check-circle" : type === "error" ? "exclamation-circle" : "info-circle"}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `

  document.body.appendChild(notification)

  // Auto remove after 5 seconds
  setTimeout(() => {
    if (notification.parentElement) {
      notification.remove()
    }
  }, 5000)
}

// Check URL parameters on page load
window.addEventListener("load", () => {
  const urlParams = new URLSearchParams(window.location.search)
  const section = urlParams.get("section")

  if (section) {
    showSection(section)
  }

  // Show success/error messages
  if (urlParams.get("success")) {
    showNotification("Data berhasil disimpan!", "success")
  }

  if (urlParams.get("error")) {
    showNotification("Terjadi kesalahan. Silakan coba lagi.", "error")
  }
})

// Handle browser back/forward buttons
window.addEventListener("popstate", (e) => {
  const urlParams = new URLSearchParams(window.location.search)
  const section = urlParams.get("section") || "home"
  showSection(section)
})
