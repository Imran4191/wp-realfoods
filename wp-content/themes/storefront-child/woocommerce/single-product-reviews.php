<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}
$rating_counts = $product->get_rating_counts();
$five_star = isset($rating_counts[5]) ? $rating_counts[5] : 0;
$four_star = isset($rating_counts[4]) ? $rating_counts[4] : 0;
$three_star = isset($rating_counts[3]) ? $rating_counts[3] : 0;
$two_star = isset($rating_counts[2]) ? $rating_counts[2] : 0;
$one_star = isset($rating_counts[1]) ? $rating_counts[1] : 0;

$productId = $product->get_id();  
$productTitle = get_the_title($productId); 
$user = wp_get_current_user();
$productQaLength = get_option('ets_product_q_qa_list_length');   
$current_user = $user->exists();  
$site_url = get_site_url();

if( $current_user == true ){
    $uesrName = $user->first_name.' '.$user->last_name;
    $uesrEmail = $user->user_email;
} else {
    $uesrName = '';
    $uesrEmail = '';
}
$etsGetQuestion = array();
$all_questions = get_post_meta( $productId,'ets_question_answer', true );      
if($all_questions && is_array($all_questions)){
    $etsGetQuestion = array_filter($all_questions, function ($filterQuestion) {
        return (isset($filterQuestion['approve']) && $filterQuestion['approve'] == 'yes') || !isset($filterQuestion['approve']);
    });
}

?>
<div id="reviews" class="container woocommerce-Reviews">
    <h2 class="woocommerce-Reviews-title">
        <?php
            $totalreview = $product->get_review_count();
            echo wp_kses_post(sprintf(__('Customer Reviews %1$s', 'storefrontchild'), $totalreview));
        ?>
    </h2>
    <div class="reviewoverview">
        <div class="reviewoverview-star_section">
            <div class="reviewoverview-overall_score">
                <div class="reviewoverview-overall_review">
                    <h2><?php echo $product->get_average_rating(); ?></h2>
                    <div class="reviewoverview-stars">
                        <div class="staricon-root">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 24 24" fill="#00b1aa" stroke="#00b1aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 24 24" fill="#00b1aa" stroke="#00b1aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 24 24" fill="#00b1aa" stroke="#00b1aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 24 24" fill="#00b1aa" stroke="#00b1aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 24 24" fill="#00b1aa" stroke="#00b1aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                <p><?php echo wp_kses_post(sprintf(__('Based on <span>%1$s</span> reviews', 'storefrontchild'), $totalreview)); ?></p>
            </div>
            <div class="reviewoverview-score_category">
                <div class="reviewoverview-score_tally">
                    <div class="reviewoverview-review_legend" id="0" style="opacity: 1;">
                        <div class="staricon-root" name="rating">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                        </div>
                        <div class="reviewoverview-progress_bar_wrap">
                            <div class="reviewoverview-bar_container">
                                <?php if ($totalreview > 0): ?>
									<div class="reviewoverview-bar_progress" style="width:<?php echo ($five_star/$totalreview)*100;?>%;"></div>
								<?php else: ?>
									<div class="reviewoverview-bar_progress" style="width:0%;"></div>
								<?php endif; ?>
                            </div>
                            <p>(<?php echo $five_star; ?>)</p>
                        </div>
                    </div>
                    <div class="reviewoverview-review_legend" id="1" style="opacity: 1;">
                        <div class="staricon-root" name="rating">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                        </div>
                        <div class="reviewoverview-progress_bar_wrap">
                            <div class="reviewoverview-bar_container">
                                <?php if ($totalreview > 0): ?>
									<div class="reviewoverview-bar_progress" style="width:<?php echo ($four_star/$totalreview)*100;?>%;"></div>
								<?php else: ?>
									<div class="reviewoverview-bar_progress" style="width:0%;"></div>
								<?php endif; ?>
                            </div>
                            <p>(<?php echo $four_star; ?>)</p>
                        </div>
                    </div>
                    <div class="reviewoverview-review_legend" id="2" style="opacity: 1;">
                        <div class="staricon-root" name="rating">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                        </div>
                        <div class="reviewoverview-progress_bar_wrap">
                            <div class="reviewoverview-bar_container">
                                <?php if ($totalreview > 0): ?>
									<div class="reviewoverview-bar_progress" style="width:<?php echo ($three_star/$totalreview)*100;?>%;"></div>
								<?php else: ?>
									<div class="reviewoverview-bar_progress" style="width:0%;"></div>
								<?php endif; ?>
                            </div>
                            <p>(<?php echo $three_star; ?>)</p>
                        </div>
                    </div>
                    <div class="reviewoverview-review_legend" id="3" style="opacity: 1;">
                        <div class="staricon-root" name="rating">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                        </div>
                        <div class="reviewoverview-progress_bar_wrap">
                            <div class="reviewoverview-bar_container">
                                <?php if ($totalreview > 0): ?>
									<div class="reviewoverview-bar_progress" style="width:<?php echo ($two_star/$totalreview)*100;?>%;"></div>
								<?php else: ?>
									<div class="reviewoverview-bar_progress" style="width:0%;"></div>
								<?php endif; ?>
                            </div>
                            <p>(<?php echo $two_star; ?>)</p>
                        </div>
                    </div>
                    <div class="reviewoverview-review_legend" id="4" style="opacity: 1;">
                        <div class="staricon-root" name="rating">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#777" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                        </div>
                        <div class="reviewoverview-progress_bar_wrap">
                            <div class="reviewoverview-bar_container">
                                <?php if ($totalreview > 0): ?>
									<div class="reviewoverview-bar_progress" style="width:<?php echo ($one_star/$totalreview)*100;?>%;"></div>
								<?php else: ?>
									<div class="reviewoverview-bar_progress" style="width:0%;"></div>
								<?php endif; ?>
                            </div>
                            <p>(<?php echo $one_star; ?>)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="reviewoverview-feedback">
            <div class="reviewoverview-write_review" id="review">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="24" viewBox="0 0 24 24" fill="none" stroke="#05A69E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </span>
                <?php echo __('Write a review', 'storefrontchild'); ?>
            </div>
            <div class="reviewoverview-question" id="question">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="24" viewBox="0 0 24 24" fill="none" stroke="#05A69E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                    </svg>
                </span>
                <?php echo __('Ask a question', 'storefrontchild'); ?>
            </div>
        </div>
    </div>

    <div class="reviewsdetails">
		<div class="reviewsheader-reviews_header_nav">
            <ul class="nav nav-tabs" id="reviewQuesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="review-tab" data-bs-toggle="tab" data-bs-target="#review-tab-content" type="button" role="tab" aria-controls="review" aria-selected="true"><?php echo wp_kses_post(sprintf(__('Reviews <span>%1$s</span>', 'storefrontchild'), $totalreview)); ?></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="question-tab" data-bs-toggle="tab" data-bs-target="#question-tab-content" type="button" role="tab" aria-controls="question" aria-selected="false"><?php echo wp_kses_post(sprintf(__('Questions <span>%1$s</span>', 'storefrontchild'), count($etsGetQuestion))); ?></button>
                </li>
            </ul>
		</div>

        <div class="tab-content" id="reviewQuesTabContent">
            <div class="tab-pane fade show active" id="review-tab-content" role="tabpanel" aria-labelledby="review-tab">
                <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
                    <div id="review_form_wrapper" class="d-none">
                        <div id="review_form">
                            <?php
                            $commenter    = wp_get_current_commenter();
                            $comment_form = array(
                                /* translators: %s is product title */
                                'title_reply'         => have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
                                /* translators: %s is product title */
                                'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
                                'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
                                'title_reply_after'   => '</span>',
                                'comment_notes_after' => '',
                                'label_submit'        => esc_html__( 'Submit', 'woocommerce' ),
                                'logged_in_as'        => '',
                                'comment_field'       => '',
                            );

                            $name_email_required = (bool) get_option( 'require_name_email', 1 );
                            $fields              = array(
                                'author' => array(
                                    'label'    => __( 'Name', 'woocommerce' ),
                                    'type'     => 'text',
                                    'value'    => $commenter['comment_author'],
                                    'required' => $name_email_required,
                                ),
                                'email'  => array(
                                    'label'    => __( 'Email', 'woocommerce' ),
                                    'type'     => 'email',
                                    'value'    => $commenter['comment_author_email'],
                                    'required' => $name_email_required,
                                ),
                            );

                            $comment_form['fields'] = array();

                            foreach ( $fields as $key => $field ) {
                                $field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
                                $field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

                                if ( $field['required'] ) {
                                    $field_html .= '&nbsp;<span class="required">*</span>';
                                }

                                $field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

                                $comment_form['fields'][ $key ] = $field_html;
                            }

                            $account_page_url = wc_get_page_permalink( 'myaccount' );
                            if ( $account_page_url ) {
                                /* translators: %s opening and closing link tags respectively */
                                $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
                            }

                            if ( wc_review_ratings_enabled() ) {
                                $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
                                    <option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
                                    <option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
                                    <option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
                                    <option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
                                    <option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
                                    <option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
                                </select></div>';
                            }

                            $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';
                            if( $current_user == true ) {
                                $comment_form['comment_field'] .= '<div class="google-captcha">
                                    <div class="g-recaptcha" data-sitekey="'.UM()->options()->get( 'g_recaptcha_sitekey' ).'"></div>
                                    <div class="captcha-error"></div>
                                </div>';
                            }

                            comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
                            ?>
                        </div>
                    </div>
                <?php else : ?>
                    <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
                <?php endif; ?>

                <div id="comments">
                    <?php if ( have_comments() ) : ?>
                        <ol class="commentlist">
                            <?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
                        </ol>

                        <?php
                        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
                            echo '<nav class="woocommerce-pagination">';
                            paginate_comments_links(
                                apply_filters(
                                    'woocommerce_comment_pagination_args',
                                    array(
                                        'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
                                        'next_text' => is_rtl() ? '&larr;' : '&rarr;',
                                        'type'      => 'list',
                                    )
                                )
                            );
                            echo '</nav>';
                        endif;
                        ?>
                    <?php endif; ?>
                </div>
                <div class="clear"></div>
            </div>

            <div class="tab-pane fade" id="question-tab-content" role="tabpanel" aria-labelledby="question-tab">
                <div class="question-form d-none">
                    <div class="question-add">
                        <div class="block-content">
                            <form action="#" method="post"  id="ets-qus-form" name="form">
                                <input type="hidden" id="productId" class="productId" name="product_id" value="<?php echo $productId ?>">
                                <input type="hidden" id="productlength" class="productlength" name="Product_Qa_Length" value="<?php echo $productQaLength ?>">  
                                <input type="hidden" id="producttitle" name="ets_Product_Title" value="<?php echo $productTitle ?>">
                                <div class="question-name-email">
                                    <div class="field question-field-name required">
                                        <label for="name_field" class="label"><span><?php echo __('Name', 'storefrontchild'); ?></span></label> 
                                        <div class="control"><input required type="text" name="user_name" id="author_name" class="input-text" data-validate="{required:true}" aria-required="true" placeholder="<?php echo __('Enter your name', 'storefrontchild'); ?>" value="<?php echo $uesrName; ?>"></div>
                                    </div>
                                    <div class="field question-field-email required">
                                        <label for="email_field" class="label"><span><?php echo __('Email', 'storefrontchild'); ?></span></label> 
                                        <div class="control"><input required type="text" name="usermail" id="author_email" class="input-text" data-validate="{required:true, 'validate-email':true}" aria-required="true" placeholder="<?php echo __('john@example.com', 'storefrontchild'); ?>" value="<?php echo $uesrEmail; ?>"></div>
                                    </div>
                                </div>
                                <div class="field question-field-detail required">
                                    <label for="detail" class="label"><span><?php echo __('Question', 'storefrontchild'); ?></span></label> 
                                    <div class="control">
                                        <textarea required name="question" id="ques-text-ar" cols="5" rows="6" placeholder="<?php echo __('Write your question here', 'storefrontchild'); ?>" data-validate="{required:true, minlength:20}" aria-required="true"></textarea>
                                    </div>
                                </div>
                                <div class="ets-display-message"><p></p></div>
                                <div class="ets-dis-message-error"><p></p></div>
                                <div class="question-actions">
                                    <div class="google-captcha">
                                        <div class="g-recaptcha" data-sitekey="<?php echo UM()->options()->get( 'g_recaptcha_sitekey' ); ?>"></div>
                                        <div class="captcha-error"></div>
                                    </div>
                                    <div class="actions-toolbar question-form-actions">
                                        <div class="primary actions-primary">
                                            <button id="ets-submit" type="submit" name="submit" class="action submit primary" ><?php echo __('Submit Question','storefrontchild'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 

                <?php if(!empty($etsGetQuestion)) : ?>
                    <div class="question-list">
                        <div id="product-question-container" data-role="product-question">
                            <div class="box-question-list">
                                <div class="question-details">
                                    <div class="customerreviews-reviews_container">
                                        <?php
                                        $questions_per_page = 5; // Number of questions per page
                                        $current_page = isset($_GET['question_page']) ? intval($_GET['question_page']) : 1;
                                        $total_questions = count($etsGetQuestion);
                                        $total_pages = ceil($total_questions / $questions_per_page);
                                        $start_index = ($current_page - 1) * $questions_per_page;
                                        $questions_to_display = array_slice($etsGetQuestion, $start_index, $questions_per_page);

                                        foreach ($questions_to_display as $key => $value) : ?>
                                            <div class="questionitem-root">
                                                <div class="questionitem-question_container">
                                                    <div class="questionitem-question_header">
                                                        <h3 class="questionitem-name"><?php echo $value['user_name']; ?></h3>
                                                        <small class="questionitem-reply_date"><?php echo $value['date']; ?></small>
                                                    </div>
                                                    <div class="questionitem-question_content">
                                                        <p class="review_content"><?php echo $value['question'];?></p>
                                                    </div>
                                                    <div class="questionitem-qa_icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="#00456a" stroke="#00456a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                                        </svg>
                                                        <p>Answers<span>(1)</span></p>
                                                    </div>
                                                </div>
                                                <div class="questionitem-question_answer">
                                                    <div class="questionitem-question_answer_header">
                                                        <h3 class="questionitem-question_answer_name"><?php echo __('Rosita Real Foods', 'storefrontchild'); ?></h3>
                                                        <small class="questionitem-question_answer_date"></small>
                                                    </div>
                                                    <div class="questionitem-question_answer_content">
                                                        <p class="review_content"><?php echo $value['answer'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($total_pages > 1) : ?>
                        <nav class="woocommerce-pagination">
                            <ul class="page-numbers">
                                <?php if ($current_page > 1) : ?>
                                    <li><a class="prev page-numbers" href="?question_page=<?php echo $current_page - 1; ?>">&larr;</a></li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                    <li><a class="page-numbers <?php echo $i == $current_page ? 'current' : ''; ?>" href="?question_page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php endfor; ?>

                                <?php if ($current_page < $total_pages) : ?>
                                    <li><a class="next page-numbers" href="?question_page=<?php echo $current_page + 1; ?>">&rarr;</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
	</div>
</div>

<script>
    jQuery(document).ready(function($) {
        // Use event delegation on a static parent element
        $("#reviews").on("click", ".woocommerce-pagination a", function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            var questionPage = link.split('question_page=')[1];

            // Load and fade out comments section
            $('#comments').fadeOut(300, function() {
                $('#comments').before('<p id="loading-text">Loading Reviews...</p>');
                $('#comments').load(link + ' #comments', function() {
                    $(this).fadeIn(300, function() {
                        $('#loading-text').remove(); // Remove loading text after fadeIn is done
                    });
                });
            });

            // Load and fade out product question container
            $('#product-question-container').fadeOut(300, function() {
                $('#product-question-container').before('<p id="loading-text">Loading Questions...</p>');
                $('#product-question-container').load(link + ' #product-question-container', function() {
                    $(this).fadeIn(300, function() {
                        $('#loading-text').remove(); // Remove loading text after fadeIn is done
                    });
                });
            });
        });
    });
</script>
