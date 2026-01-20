/**
 * SIKANDIS - Print QR Logic
 */

document.addEventListener('DOMContentLoaded', function() {
    const printBtn = document.getElementById('printBtn');
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            window.print();
        });
    }
});
