
document.addEventListener("DOMContentLoaded", function() {
    const productList = document.querySelector(".product-list");
    const leftBtn = document.querySelector(".slider-btn.left");
    const rightBtn = document.querySelector(".slider-btn.right");

    leftBtn.addEventListener("click", () => {
        productList.scrollBy({ left: -200, behavior: "smooth" });
    });

    rightBtn.addEventListener("click", () => {
        productList.scrollBy({ left: 200, behavior: "smooth" });
    });
});

