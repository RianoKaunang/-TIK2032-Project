window.onload = function () {
    const path = window.location.pathname;

    if (path.includes("index.html")) {
        alert("Selamat datang di halaman utama!");
    } else if (path.includes("gallery.html")) {
        alert("Selamat datang di halaman gallery!");
    } else if (path.includes("blog.html") || path.includes("blog.php")) {
        alert("Selamat datang di halaman blog!");
    } else if (path.includes("contact.html")) {
        alert("Selamat datang di halaman kontak!");
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contact-form');
    const submitBtn = document.getElementById('submit-btn');
    const formMessage = document.getElementById('form-message');
    const inputs = form.querySelectorAll('input, textarea');
    const notification = document.getElementById('notification');

    // Handle form submission
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        submitBtn.classList.add('pulse');
        submitBtn.disabled = true;

        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            form.classList.add('form-success');
            inputs.forEach(input => input.classList.add('field-clear'));

            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });

            form.reset();
            submitBtn.innerHTML = 'Kirim Pesan';
            submitBtn.classList.remove('pulse');
            submitBtn.disabled = false;

            showNotification('Pesan Anda telah terkirim!');
        })
        .catch(error => {
            const errorMessage = document.createElement('p');
            errorMessage.className = 'form-message error shake';
            errorMessage.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
            form.parentNode.insertBefore(errorMessage, form);
            form.classList.add('form-error');
            submitBtn.innerHTML = 'Kirim Pesan';
            submitBtn.classList.remove('pulse');
            submitBtn.disabled = false;
        });
    });

    if (formMessage && formMessage.classList.contains('error')) {
        formMessage.classList.add('shake');
        form.classList.add('form-error');
    }

    function showNotification(message) {
        notification.textContent = message;
        notification.classList.add('show');
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }
});
