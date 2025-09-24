<?php
/*
Template Name: Faq
*/
get_header(); ?>
<div class="contact-faq-banner">
   <div class="container"> <!-- Changed from 'page-main' to 'container' for Bootstrap's container -->
      <div class="columns row">
         <div class="col-12 col-md-12 col-lg-8 offset-lg-2"> <!-- Updated column and offset classes -->
            <div class="faq-header">
               <div class="faq-description">
                  <h2>FAQs</h2>
                  <hr>
                  <p> Please see our list of answers to frequently asked questions below. If you still cannot find the answer to your question, click the following link to <a href="/contact/" title="Contact Us">contact us</a>.</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="page-main faq-view">
    <div class="columns row">
        <div class="col-12 col-md-12 col-lg-8 offset-lg-2">
            <div class="panel-group" id="faq-accordion" role="tablist" aria-multiselectable="true">
                <?php echo do_shortcode('[xyz-ips snippet="faq-question"]'); ?> 
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>