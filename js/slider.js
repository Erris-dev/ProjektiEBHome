
const productContainer = document.querySelector('.product-container');
const prevBtn = document.getElementById('prev-btn-1');
const nextBtn = document.getElementById('next-btn-1');

const productContainer1 = document.querySelector('.product-container1');
const prevBtn1 = document.getElementById('prev-btn-2');
const nextBtn1 = document.getElementById('next-btn-2');

const productContainer2 = document.getElementById('offers-sec');
const prevBtn2 = document.getElementById('prev-btn-3');
const nextBtn2 = document.getElementById('next-btn-3');

const scrollAmount = 220;  
const scrollAmountOffers = 500;

prevBtn.addEventListener("click", () => {
    productContainer.scrollLeft -= scrollAmount;  
});

nextBtn.addEventListener("click", () => {
    productContainer.scrollLeft += scrollAmount;  
});

prevBtn1.addEventListener("click", () => {
    productContainer1.scrollLeft -= scrollAmount;  
});

nextBtn1.addEventListener("click", () => {
    productContainer1.scrollLeft += scrollAmount; 
});


document.addEventListener("DOMContentLoaded", () => {
    const menuBtn = document.querySelector("#menu-btn");
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector(".close-btn");

    menuBtn.addEventListener("click", () => {
        sidebar.classList.add("active");
    });

    closeBtn.addEventListener("click", () => {
        sidebar.classList.remove("active");
    });
});
