/**
 * MTQ Aceh XXXVII Countdown JavaScript
 * Created by @saipulbahri-it
 */

// Countdown functionality
const daysEl = document.getElementById("days");
const hoursEl = document.getElementById("hours");
const minutesEl = document.getElementById("minutes");
const secondsEl = document.getElementById("seconds");
const targetDate = new Date("2025-11-01T00:00:00").getTime();

function padZero(num, digits = 2) {
  return num.toString().padStart(digits, "0");
}

function updateCountdown() {
  const now = new Date().getTime();
  const diff = targetDate - now;

  if (diff > 0) {
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
    const minutes = Math.floor((diff / 1000 / 60) % 60);
    const seconds = Math.floor((diff / 1000) % 60);

    if (daysEl) daysEl.textContent = padZero(days, 3);
    if (hoursEl) hoursEl.textContent = padZero(hours);
    if (minutesEl) minutesEl.textContent = padZero(minutes);
    if (secondsEl) secondsEl.textContent = padZero(seconds);
  } else {
    if (daysEl) daysEl.textContent = "000";
    if (hoursEl) hoursEl.textContent = "00";
    if (minutesEl) minutesEl.textContent = "00";
    if (secondsEl) secondsEl.textContent = "00";
  }
}

// Initialize countdown only if elements exist
if (daysEl || hoursEl || minutesEl || secondsEl) {
  updateCountdown();
  setInterval(updateCountdown, 1000);
}