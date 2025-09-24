<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<link rel="preload" href="https://rositarealfoods.co.uk/wp-content/uploads/2025/02/RRF_REVIEW_Homepage_Mobile-Smaller.webp" as="image" media="(max-width: 480px)">
	<link rel="preload" href="https://rositarealfoods.co.nz/wp-content/uploads/sites/2/2025/02/RRF_REVIEW_Homepage_Mobile-Smaller.webp" as="image" media="(max-width: 480px)">
	<link rel="preload" href="https://rositarealfoods.eu/wp-content/uploads/sites/4/2025/02/RRF_REVIEW_Homepage_Mobile-Smaller.webp" as="image" media="(max-width: 480px)">
	<link rel="preload" href="https://rositarealfoods.com.au/wp-content/uploads/sites/3/2025/02/RRF_REVIEW_Homepage_Mobile-Smaller.webp" as="image" media="(max-width: 480px)">
	<link rel="preload" href="https://rositarealfoods.co.uk/wp-content/uploads/2025/02/RRF_REVIEW_Homepage_Banner-1.webp" as="image" media="(min-width: 481px)">
	<link rel="preload" href="https://rositarealfoods.co.nz/wp-content/uploads/sites/2/2025/02/RRF_REVIEW_Homepage_Banner-1.webp" as="image" media="(min-width: 481px)">
	<link rel="preload" href="https://rositarealfoods.com.au/wp-content/uploads/sites/3/2025/02/RRF_REVIEW_Homepage_Banner-1.webp" as="image" media="(min-width: 481px)">
	<link rel="preload" href="https://rositarealfoods.eu/wp-content/uploads/sites/4/2025/02/RRF_REVIEW_Homepage_Banner-1.webp" as="image" media="(min-width: 481px)">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php do_action('storefront_before_site'); ?>

	<div id="page" class="hfeed site">
		<?php do_action('storefront_before_header'); ?>

		<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">
			<?php echo do_shortcode('[xyz-ips snippet="Promo-Banner"]'); ?>
			<div class="header-wrapper-top">
				<div class="header-left">
					<div class="header-burger">
						<input type="checkbox" id="menu-toggle" class="ui-toggle">
						<div class="header-menu-toggle">
							<label for="menu-toggle" class="brgr">
								<span></span>
							</label>
						</div>
					</div>
					<?php echo get_custom_logo() ?>
				</div>
				<div class="header-icons">
					<div class="shop-link-navigation">
						<span>Shop</span>
						<div class="shop-dropdown-content">
							<div class="row">
								<div class="col-sm-6">
									<?php wp_nav_menu(array('container_class' => 'left-content', 'theme_location' => 'secondary')); ?>
								</div>
								<div class="col-sm-6">
									<div class="right-content">
										<?php if (get_current_blog_id() == 1): ?>
											<img src="<?php echo get_theme_file_uri() ?>/assets/images/shop-menu-updated.webp"
												alt="shop-menu">
										<?php elseif (get_current_blog_id() == 2): ?>
											<img src="<?php echo get_theme_file_uri() ?>/assets/images/shop-menu-nz.webp"
												alt="shop-menu">
										<?php elseif (get_current_blog_id() == 3): ?>
											<img src="<?php echo get_theme_file_uri() ?>/assets/images/shop-menu-au.webp"
												alt="shop-menu">
										<?php else: ?>
											<img src="<?php echo get_theme_file_uri() ?>/assets/images/shop-menu-update-eu.webp"
												alt="shop-menu">
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="track-order-top"><a href="<?php echo home_url('trackorder'); ?>"
							class="tracking-link">TRACK MY ORDER</a></div>
					<div class="block block-search">
						<?php
						echo storefront_product_search();
						?>
					</div>
					<!-- <div class="rosita-search"><a href="#" aria-label="Search Icon"></a></div> -->
					<div class="rosita-minicart">
						<?php echo do_shortcode('[fk_cart_menu]'); ?>
					</div>
					<div class="rosita-login" data-label="or">
						<?php if (is_user_logged_in()): ?>
							<?php
							$current_user = wp_get_current_user();
							$role = $current_user->roles[0];
							if ($role == 'um_practitioner') {
								$type = 'practitioner';
							} elseif ($role == 'um_practitioner-client') {
								$type = 'client';
							} elseif ($role == 'um_reseller') {
								$type = 'reseller';
							} elseif ($role == 'um_pensioner') {
								$type = 'pensioner';
							} else {
								$type = 'Logged In';
							}
							?>
							<img src="<?php echo get_theme_file_uri() ?>/assets/images/login-icon-active-v2.svg"
								alt="My Account" width="20" height="20">
							<span class="account-type"><?php echo $type; ?></span>
						<?php else: ?>
							<img src="<?php echo get_theme_file_uri() ?>/assets/images/login-icon-v2.svg" alt="My Account"
								width="20" height="20">
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="header-search-container">
				<div class="header-search-inner">
					<?php
					echo storefront_product_search();
					?>
				</div>
			</div>

			<!-- Slide Menu -->
			<div id="site-navigation">
				<?php wp_nav_menu(array('container_class' => 'navigation', 'theme_location' => 'primary')); ?>
				<div class="side-social">
					<p>Follow us on your<br> favourite social channel</p>
					<a href="https://www.facebook.com/rositarealfoods/" aria-label="facebook" target="_blank"><span
							class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i> <i
								class="fab fa-facebook-f fa-stack-1x fa-inverse"></i></span></a>
					<a href="https://twitter.com/rositarealfoods/" aria-label="twitter" target="_blank"><span
							class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i> <i
								class="fab fa-x-twitter fa-stack-1x fa-inverse"></i></span></a>
					<a href="https://www.instagram.com/rositarealfoods/?hl=en" aria-label="instagram"
						target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i> <i
								class="fab fa-instagram fa-stack-1x fa-inverse"></i></span></a>
					<a href="https://www.pinterest.co.uk/rositarealfoods/?eq=rosita%20real%20food&amp;etslf=5409"
						aria-label="printerest" target="_blank"><span class="fa-stack fa-lg"><i
								class="fa fa-circle fa-stack-2x"></i> <i
								class="fab fa-pinterest fa-stack-1x fa-inverse"></i></span></a>
				</div>
			</div>
			<!-- Slide Login -->
			<section id="slide-login" class="rosita-login-wrapper">
				<?php if (!is_user_logged_in()): ?>
					<p class="slide-heading">Customer Login</p>
					<?php
					echo do_shortcode('[xyz-ips snippet="Login-Form"]');
				endif;
				?>
				<?php if (!is_user_logged_in()): ?>
					<div class="registration-link">
						<a href="<?php echo wp_registration_url(); ?>" class="btn btn-default btn-green-inverse"
							title="Register">Sign Up</a>
					</div>
				<?php endif; ?>
				<?php if (is_user_logged_in()): ?>
					<div class="account-btn">
						<a href="<?php echo wc_get_page_permalink('myaccount'); ?>" class="btn btn-default btn-green"
							id="my-account-button">MY ACCOUNT</a>
						<a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-default btn-green-inverse"
							id="logout-button">LOGOUT</a>
					</div>
				<?php endif; ?>
				<div class="need-help">
					<strong>Need help?</strong>
					<span><a href="/contact'" target="_blank">Customer
							Support</a></span>
				</div>
				<?php if (!is_user_logged_in()): ?>
					<div class="other-accounts">
						<p class="slide-heading">Other Accounts</p>
						<ul class="login-ul">
							<li><a href="/pensioner-account/">Pensioner Account</a></li>
							<li><a href="/practitioner-account/">Practitioner Account</a></li>
							<li><a href="/practitioner-client/">Practitioner Client</a></li>
							<li><a href="/reseller/">Wholesale Account</a></li>
						</ul>
					</div>
					<div class="instructions">
						<p class="trouble">Trouble logging in? Try these steps:</p>
						<p>• Clear your browser cookies and cache,<br><span> then close your browser.</span></p>
						<p>• Use an incognito window.</p>
						<p>• Try using different browsers.</p>
					</div>
				<?php endif; ?>
			</section>
		</header><!-- #masthead -->

		<?php
		/**
		 * Functions hooked in to storefront_before_content
		 *
		 * @hooked storefront_header_widget_region - 10
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action('storefront_before_content');
		?>

		<div id="content" class="site-content" tabindex="-1">
			<div class="col-full">

				<?php
				do_action('storefront_content_top');