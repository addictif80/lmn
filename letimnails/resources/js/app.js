document.addEventListener('DOMContentLoaded', function() {
    // Auto-close modals on click outside
    document.querySelectorAll('.modal-overlay').forEach(function(modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('open');
            }
        });
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.open').forEach(function(modal) {
                modal.classList.remove('open');
            });
        }
    });
});
