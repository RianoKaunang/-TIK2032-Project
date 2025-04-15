window.addEventListener("load", function () {
    console.log("Halaman dimuat!");
    alert("Selamat datang di Web Riano");
});

document.addEventListener("DOMContentLoaded", function () {
    const currentPage = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll("nav a");

    navLinks.forEach(link => {
        if (link.getAttribute("href") === currentPage) {
            link.classList.add("active");
        }
    });

    // Animasi fade-in bertahap
    const fadeItems = document.querySelectorAll(".fade-target");
    fadeItems.forEach((item, index) => {
        item.style.opacity = 0;
        setTimeout(() => {
            item.classList.add("fade-in");
        }, index * 200);
    });

    // Menampilkan jam jika ada elemen dengan id 'jam'
    const jam = document.getElementById("jam");
    if (jam) {
        setInterval(() => {
            const now = new Date();
            jam.textContent = now.toLocaleTimeString();
        }, 1000);
    }
});