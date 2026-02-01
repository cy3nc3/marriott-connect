document.addEventListener('DOMContentLoaded', function() {
    console.log('Static System Loaded');
});

/* Modal Logic */
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('active');
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('active');
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal-overlay')) {
        event.target.classList.remove('active');
    }
}

/* Tab Logic */
function switchTab(group, tabId) {
    // Hide all tabs in this group
    const tabs = document.querySelectorAll(`[data-tab-group="${group}"]`);
    tabs.forEach(tab => tab.classList.remove('active'));

    // Deactivate all buttons in this group
    const btns = document.querySelectorAll(`[data-tab-btn="${group}"]`);
    btns.forEach(btn => btn.classList.remove('active'));

    // Show selected tab
    document.getElementById(tabId).classList.add('active');

    // Activate selected button
    const activeBtn = document.querySelector(`[data-tab-target="${tabId}"]`);
    if (activeBtn) activeBtn.classList.add('active');
}

/* Sidebar Toggle (Mobile) */
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
}

/* Simple Alerts */
function showAlert(message) {
    alert(message);
}

function confirmAction(message) {
    return confirm(message);
}
