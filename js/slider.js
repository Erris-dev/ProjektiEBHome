
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
    productContainer.scrollLeft -= scrollAmount;  // Scroll left
});

nextBtn.addEventListener("click", () => {
    productContainer.scrollLeft += scrollAmount;  // Scroll right
});

prevBtn1.addEventListener("click", () => {
    productContainer1.scrollLeft -= scrollAmount;  // Scroll left
});

nextBtn1.addEventListener("click", () => {
    productContainer1.scrollLeft += scrollAmount;  // Scroll right
});

prevBtn2.addEventListener("click", () => {
    productContainer2.scrollLeft -= scrollAmountOffers;  // Scroll left
});

nextBtn2.addEventListener("click", () => {
    productContainer2.scrollLeft += scrollAmountOffers;  // Scroll right
});
