// Get references to elements
const productItems = document.querySelectorAll('.product-item');
const seeMoreButton = document.querySelector('.pagination .see-more');

// Set initial state
let currentPage = 1;
const itemsPerPage = 8;

// Function to show products based on current page
function updateProducts() {
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;

  productItems.forEach((item, index) => {
    if (index >= startIndex && index < endIndex) {
      item.style.display = 'block';
    } else {
      item.style.display = 'none';
    }
  });

  // Hide the "See more" button if all products are displayed
  if (endIndex >= productItems.length) {
    seeMoreButton.style.display = 'none';
  } else {
    seeMoreButton.style.display = 'block';
  }
}

// Function to handle click on "See more" button
seeMoreButton.addEventListener('click', () => {
  currentPage++;
  updateProducts();
});

// Show initial products
updateProducts();
