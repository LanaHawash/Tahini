function openCart() {
    document.getElementById("cartSidebar").style.right = "0";
    document.getElementById("overlay").style.display = "block";

}

// Close Cart Sidebar
function closeCart() {
    document.getElementById("cartSidebar").style.right = "-100%";
    document.getElementById("overlay").style.display = "none";

}
function toggleMenu() {
    document.querySelector(".nav-menu").classList.toggle("active");
}
