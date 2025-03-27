function openCart() {
    document.getElementById("cartSidebar").style.right = "0";
    document.getElementById("overlay").style.display = "block";
    //document.querySelector("nav.navbar").style.display="none";
}

// Close Cart Sidebar
function closeCart() {
    document.getElementById("cartSidebar").style.right = "-100%";
    document.getElementById("overlay").style.display = "none";
    // document.querySelector("nav.navbar").style.display="flex";
}
function toggleMenu() {
    document.querySelector(".nav-menu").classList.toggle("active");


}


function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('open');
    document.querySelector("header").style.display="none";
}
function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('open');
    document.querySelector("header").style.display="flex";
}
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        closeModal(event.target.id);

    }
}

document.getElementById('catalog-btn').addEventListener('click', function(event) {
    event.preventDefault();
    let submenu = document.getElementById('submenu');
    submenu.style.display = submenu.style.display === 'flex' ? 'none' : 'flex';
});

document.getElementById('explore-btn').addEventListener('click', function(event) {
    event.preventDefault();
    let submenu = document.getElementById('explore-submenu');
    submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
});


document.querySelectorAll('.faq-item').forEach(item => {
    item.addEventListener('click', () => {
        const answer = item.querySelector('.faq-answer');
        const icon = item.querySelector('span');

        if (answer.style.display === "block") {
            answer.style.display = "none";
            icon.textContent = "+";
        } else {
            document.querySelectorAll('.faq-answer').forEach(a => a.style.display = "none");
            document.querySelectorAll('.faq-item span').forEach(i => i.textContent = "+");

            answer.style.display = "block";
            icon.textContent = "-";
        }
    });
});