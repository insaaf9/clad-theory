<!-- Toast Notification Container -->
<div class="toast-container" id="toastContainer" aria-live="polite"></div>

</main><!-- /.admin-main -->

<script>
/* ======================================================
   ADMIN SHARED JS — Toast Utility
   ====================================================== */
function showToast(message, type = 'info') {
    const icons = { success: '✅', error: '❌', info: 'ℹ️' };
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast toast--${type}`;
    toast.innerHTML = `
        <span class="toast__icon">${icons[type] || icons.info}</span>
        <span class="toast__msg">${message}</span>
    `;
    container.appendChild(toast);
    setTimeout(() => {
        toast.classList.add('hiding');
        toast.addEventListener('animationend', () => toast.remove());
    }, 3200);
}
</script>
</body>
</html>
