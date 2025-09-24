<?php

global $product;

$product_name = $product->get_name();
$product_attr = $product->get_attribute('Key Nutritional Facts');
$product_tab1 = $product->get_attribute('Product Tab1 Title');
$product_tab2 = $product->get_attribute('Product Tab2 Title');
$product_tab3 = $product->get_attribute('Product Tab3 Title');
$product_tab4 = $product->get_attribute('Product Tab4 Title');
$product_tab5 = $product->get_attribute('Product Tab5 Title');
$product_tab6 = $product->get_attribute('Video');
$product_overview = $product->get_attribute('product_tab_1');
$product_ingredients = $product->get_attribute('Product Ingredients');
$product_benefits = $product->get_attribute('Product Benefits');
$product_dosage = $product->get_attribute('Product Dosage');
$product_storage = $product->get_attribute('Product Storage');
$product_video = $product->get_attribute('Video');

// Check if we should activate video tab by default
$activate_video = isset($_GET['tab']) && $_GET['tab'] === 'video';
?>

<script>
// Immediate hash detection before DOM elements are created
var activateVideoTab = window.location.hash === '#product6' || 
                      window.location.search.includes('tab=video') ||
                      <?php echo $activate_video ? 'true' : 'false'; ?>;

if (activateVideoTab) {
    document.documentElement.className += ' activate-video-tab';
}
</script>

<style>
/* CSS to handle video tab activation immediately */
.activate-video-tab .nav-tabs li:not(:last-child) {
    background-color: transparent !important;
}

/* Force video tab styling when URL contains tab=video */
body:has(.activate-video-tab) #video-tab-li,
.activate-video-tab #video-tab-li {
    background-color: transparent !important;
}
#video-tab-li{
   border-bottom: 3px solid #00456a !important;
}
#video-tab-li a {
    color: #00456a !important;
    font-weight: 600 !important;
}

/* Hide all regular content when video tab is active - DESKTOP ONLY */
@media (min-width: 769px) {
    .activate-video-tab #product1,
    .activate-video-tab #product2,
    .activate-video-tab #product3,
    .activate-video-tab #product4,
    .activate-video-tab #product5 {
        display: none !important;
    }
}

/* Show video content when activated */
.activate-video-tab #product6 {
    display: block !important;
    opacity: 1 !important;
}

/* Mobile accordion - responsive handling */
@media (max-width: 768px) {
    /* Show all accordion items by default on mobile */
    .container.mobile .accordion-item {
        display: block !important;
    }
    
    .activate-video-tab .container.mobile #collapseVideo {
        display: block !important;
    }
}

/* Desktop accordion behavior (unchanged) */
@media (min-width: 769px) {
    .activate-video-tab .accordion-item:not(:last-child) {
        display: none !important;
    }
    
    .activate-video-tab #collapseVideo {
        display: block !important;
    }
}
@media (max-width: 768px) {
    .activate-video-tab .mobile-accordion-item {
        display: none !important;
    }
    
    .activate-video-tab .mobile-accordion-item:last-child {
        display: block !important;
    }
}

</style>

<div class="container">
  
<ul class="nav nav-tabs">
    <li class="<?php echo $activate_video ? '' : 'active'; ?>">
        <a data-toggle="tab" href="#product1">Description</a>
    </li>
    <li>
        <a data-toggle="tab" href="#product2">Ingredients</a>
    </li>
    <?php if(get_current_blog_id()!=2) : ?>
        <li>
            <a data-toggle="tab" href="#product3">Benefits</a>
        </li>
    <?php endif; ?>
    <li>
        <a data-toggle="tab" href="#product4">Dosage</a>
    </li>
    <li>
        <a data-toggle="tab" href="#product5">Storage</a>
    </li>

    <?php if(!empty($product_tab6)): ?>
        <li id="video-tab-li" class="<?php echo $activate_video ? 'active' : ''; ?>">
            <a data-toggle="tab" href="#product6">Video</a>
        </li>
    <?php endif; ?>
</ul>

  <div class="tab-content-wrapper">
    <div class="tab-content">
    
        <div id="product1" class="tab-pane fade <?php echo $activate_video ? '' : 'active in'; ?> product-info-details">
            <?php echo $product_overview; ?>
        </div>
        
        <div id="product2" class="tab-pane fade product-info-details">
            <?php echo $product_ingredients; ?>
        </div>
        
        <?php if(get_current_blog_id()!=2) : ?>
        <div id="product3" class="tab-pane fade product-info-details">
            <?php echo $product_benefits; ?>
        </div>
        <?php endif; ?>
        
        <div id="product4" class="tab-pane fade product-info-details">
            <?php echo $product_dosage; ?>
        </div>
        
        <div id="product5" class="tab-pane fade product-info-details">
            <?php echo $product_storage; ?>
        </div>
        
        <?php if(!empty($product_tab6)): ?>
            <div id="product6" class="tab-pane fade <?php echo $activate_video ? 'active in' : ''; ?> product-info-details">
                <?php echo $product_video; ?>
            </div>
        <?php endif; ?>
    </div>
  </div>
</div>

<div class="container mobile">
  <div class="accordion" id="productAccordion">

    <div class="accordion-item mobile-accordion-item" <?php echo $activate_video ? 'style="display:none;"' : ''; ?>>
      <h2 class="accordion-header" id="headingOverview">
        <button class="accordion-button <?php echo $activate_video ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOverview" aria-expanded="<?php echo $activate_video ? 'false' : 'true'; ?>" aria-controls="collapseOverview">
          Description
        </button>
      </h2>
      <div id="collapseOverview" class="accordion-collapse collapse <?php echo $activate_video ? '' : 'show'; ?>" aria-labelledby="headingOverview" data-bs-parent="#productAccordion">
        <div class="accordion-body">
          <?php echo $product_overview; ?>
        </div>
      </div>
    </div>

    <div class="accordion-item" <?php echo $activate_video ? 'style="display:none;"' : ''; ?>>
      <h2 class="accordion-header" id="headingIngredients">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIngredients" aria-expanded="false" aria-controls="collapseIngredients">
          Ingredients
        </button>
      </h2>
      <div id="collapseIngredients" class="accordion-collapse collapse" aria-labelledby="headingIngredients" data-bs-parent="#productAccordion">
        <div class="accordion-body">
          <?php echo $product_ingredients; ?>
        </div>
      </div>
    </div>

    <?php if(get_current_blog_id() != 2): ?>
    <div class="accordion-item" <?php echo $activate_video ? 'style="display:none;"' : ''; ?>>
      <h2 class="accordion-header" id="headingBenefits">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBenefits" aria-expanded="false" aria-controls="collapseBenefits">
          Benefits
        </button>
      </h2>
      <div id="collapseBenefits" class="accordion-collapse collapse" aria-labelledby="headingBenefits" data-bs-parent="#productAccordion">
        <div class="accordion-body">
          <?php echo $product_benefits; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <div class="accordion-item" <?php echo $activate_video ? 'style="display:none;"' : ''; ?>>
      <h2 class="accordion-header" id="headingDosage">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDosage" aria-expanded="false" aria-controls="collapseDosage">
          Dosage
        </button>
      </h2>
      <div id="collapseDosage" class="accordion-collapse collapse" aria-labelledby="headingDosage" data-bs-parent="#productAccordion">
        <div class="accordion-body">
          <?php echo $product_dosage; ?>
        </div>
      </div>
    </div>

    <div class="accordion-item" <?php echo $activate_video ? 'style="display:none;"' : ''; ?>>
      <h2 class="accordion-header" id="headingStorage">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStorage" aria-expanded="false" aria-controls="collapseStorage">
          Storage
        </button>
      </h2>
      <div id="collapseStorage" class="accordion-collapse collapse" aria-labelledby="headingStorage" data-bs-parent="#productAccordion">
        <div class="accordion-body">
          <?php echo $product_storage; ?>
        </div>
      </div>
    </div>

    <?php if(!empty($product_tab6)): ?>
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingVideo">
        <button class="accordion-button <?php echo $activate_video ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVideo" aria-expanded="<?php echo $activate_video ? 'true' : 'false'; ?>" aria-controls="collapseVideo">
          Video
        </button>
      </h2>
      <div id="collapseVideo" class="accordion-collapse collapse <?php echo $activate_video ? 'show' : ''; ?>" aria-labelledby="headingVideo" data-bs-parent="#productAccordion">
        <div class="accordion-body">
          <?php echo $product_video; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function isMobile() {
        return window.innerWidth <= 768;
    }
    
    function handleVideoTabActivation() {
        var shouldActivate = window.location.hash === '#product6' || 
                           window.location.search.includes('tab=video');
        
        if (shouldActivate) {
            // Remove the CSS override class to let Bootstrap work normally
            document.documentElement.classList.remove('activate-video-tab');
            
            if (isMobile()) {
                // Mobile-specific handling
                // Show all accordion items first
                document.querySelectorAll('.container.mobile .accordion-item').forEach(function(item) {
                    item.style.display = 'block';
                });
                
                // Close all accordion panels first
                document.querySelectorAll('.accordion-collapse').forEach(function(collapse) {
                    collapse.classList.remove('show');
                });
                
                // Open only the video accordion
                var videoCollapse = document.getElementById('collapseVideo');
                var videoButton = document.querySelector('#headingVideo .accordion-button');
                if (videoCollapse && videoButton) {
                    videoCollapse.classList.add('show');
                    videoButton.classList.remove('collapsed');
                    videoButton.setAttribute('aria-expanded', 'true');
                }
                
                // Then apply the hiding via CSS class
                setTimeout(function() {
                    document.documentElement.classList.add('activate-video-tab');
                }, 100);
            } else {
                // Desktop handling (unchanged)
                document.querySelectorAll('.nav-tabs li').forEach(function(li, index, list) {
                    li.classList.remove('active');
                    if (index === list.length - 1) {
                        li.classList.add('active');
                    }
                });
                
                document.querySelectorAll('.tab-pane').forEach(function(pane) {
                    pane.classList.remove('active', 'in');
                    if (pane.id === 'product6') {
                        pane.classList.add('active', 'in');
                    }
                });
                
                document.querySelectorAll('.accordion-collapse').forEach(function(collapse) {
                    collapse.classList.remove('show');
                    if (collapse.id === 'collapseVideo') {
                        collapse.classList.add('show');
                    }
                });
            }
            
            // Scroll to tabs (both mobile and desktop)
            setTimeout(function() {
              var target;
              if (isMobile()) {
                  // On mobile, scroll to the video accordion specifically
                  target = document.querySelector('#headingVideo') || document.querySelector('#productAccordion');
              } else {
                  // On desktop, scroll to nav tabs
                  target = document.querySelector('.nav-tabs') || document.querySelector('#productAccordion');
              }
              
              if (target) {
                  target.scrollIntoView({ behavior: 'smooth', block: 'start' });
              }
          }, 300);
        } else {
            document.documentElement.classList.remove('activate-video-tab');
        }
    }
    
    // Handle desktop tab clicks
    document.querySelectorAll('.nav-tabs a[data-toggle="tab"]').forEach(function(tab) {
        tab.addEventListener('click', function(e) {
            document.documentElement.classList.remove('activate-video-tab');
            
            document.querySelectorAll('.nav-tabs li').forEach(function(li) {
                li.classList.remove('active');
            });
            
            this.parentElement.classList.add('active');
            
            var videoTab = document.getElementById('video-tab-li');
            if (videoTab && this.getAttribute('href') !== '#product6') {
                videoTab.removeAttribute('id');
            }
        });
    });
    
    // Handle mobile accordion clicks
    document.querySelectorAll('.accordion-button').forEach(function(button) {
      button.addEventListener('click', function(e) {
          if (isMobile()) {
              var targetId = this.getAttribute('data-bs-target');
              if (targetId === '#collapseVideo') {
                  // Video accordion clicked - remove the forced activation
                  document.documentElement.classList.remove('activate-video-tab');
                  
                  // Show all accordion items when collapsing video
                  document.querySelectorAll('.container.mobile .accordion-item').forEach(function(item) {
                      item.style.display = 'block';
                  });
              } else if (targetId !== '#collapseVideo') {
                  document.documentElement.classList.remove('activate-video-tab');
                  
                  // Show all accordion items when clicking away from video
                  document.querySelectorAll('.container.mobile .accordion-item').forEach(function(item) {
                      item.style.display = 'block';
                  });
              }
          }
      });
  });
    
    // Handle window resize to switch between mobile/desktop behavior
    window.addEventListener('resize', function() {
        if (window.location.search.includes('tab=video') || window.location.hash === '#product6') {
            setTimeout(handleVideoTabActivation, 100);
        }
    });
    
    handleVideoTabActivation();
    window.addEventListener('hashchange', handleVideoTabActivation);
    
    // Multiple timing checks for reliability
    setTimeout(handleVideoTabActivation, 100);
    setTimeout(handleVideoTabActivation, 500);
});
</script>