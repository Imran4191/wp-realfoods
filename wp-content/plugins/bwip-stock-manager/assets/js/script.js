jQuery(document).ready(function ($) {
  function fetchProducts(page = 1, search = "") {
    $.ajax({
      url: bwipStockManager.ajaxUrl,
      method: "POST",
      data: {
        action: "bwip_get_products",
        page: page,
        search: search,
      },
      success: function (response) {
        if (response.success) {
          let products = response.data.products.map(
            (product) => `
                        <div class="product-item">
                            <a href="${product.link}">${product.name}</a>
                            <p>SKU: ${product.sku}</p>
                            <p>Status: ${product.status}</p>
                            <p>Total Quantity: ${product.total_qty}</p>
                            <p>Available Quantity: ${product.available_qty}</p>
                            <p>Quantity to Ship: ${product.qty_to_ship}</p>
                            <p>Stock Status: ${product.stock_status}</p>
                        </div>
                    `
          );
          $("#product-list").html(products);

          // Pagination controls
          let pagination = "";
          for (let i = 1; i <= response.data.max_pages; i++) {
            pagination += `<button class="pagination-btn" data-page="${i}">${i}</button>`;
          }
          $("#pagination").html(pagination);

          // Highlight the current page button
          $(`.pagination-btn[data-page="${page}"]`).addClass("active");
        } else {
          $("#product-list").html("<p>No products found.</p>");
        }
      },
    });
  }

  // Initial load with pagination
  fetchProducts();

  // Search event
  $("#product-search").on("input", function () {
    let search = $(this).val();
    fetchProducts(1, search);
  });

  // Pagination event
  $(document).on("click", ".pagination-btn", function () {
    let page = $(this).data("page");
    let search = $("#product-search").val();
    fetchProducts(page, search);
  });
});
