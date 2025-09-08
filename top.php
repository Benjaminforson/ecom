<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');
$wishlist_count = 0;
$cat_res = mysqli_query($con, "select * from categories where status=1 order by categories asc");
$cat_arr = array();
while ($row = mysqli_fetch_assoc($cat_res)) {
	$cat_arr[] = $row;
}

$obj = new add_to_cart();
$totalProduct = $obj->totalProduct();

if (isset($_SESSION['USER_LOGIN'])) {
	$uid = $_SESSION['USER_ID'];

	if (isset($_GET['wishlist_id'])) {
		$wid = get_safe_value($con, $_GET['wishlist_id']);
		mysqli_query($con, "delete from wishlist where id='$wid' and user_id='$uid'");
	}

	$wishlist_count = mysqli_num_rows(mysqli_query($con, "select product.name,product.image,product.price,product.mrp,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'"));
}

$script_name = $_SERVER['SCRIPT_NAME'];
$script_name_arr = explode('/', $script_name);
$mypage = $script_name_arr[count($script_name_arr) - 1];

$meta_title = "GhCommerce";
$meta_desc = "GhCommerce";
$meta_keyword = "GhCommerce";
if ($mypage == 'product.php') {
	$product_id = get_safe_value($con, $_GET['id']);
	$product_meta = mysqli_fetch_assoc(mysqli_query($con, "select * from product where id='$product_id'"));
	$meta_title = $product_meta['meta_title'];
	$meta_desc = $product_meta['meta_desc'];
	$meta_keyword = $product_meta['meta_keyword'];
}
if ($mypage == 'contact.php') {
	$meta_title = 'Contact Us';
}

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php echo $meta_title ?></title>
	<meta name="description" content="<?php echo $meta_desc ?>">
	<meta name="keywords" content="<?php echo $meta_keyword ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<link rel="stylesheet" href="css/core.css">
	<link rel="stylesheet" href="css/shortcode/shortcodes.css">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/responsive.css">
	<link rel="stylesheet" href="css/custom.css">
	<script src="js/vendor/modernizr-3.5.0.min.js"></script>
	<style>
		.htc__shopping__cart a span.htc__wishlist {
			background: rgb(216, 90, 59);
			border-radius: 100%;
			color: #fff;
			font-size: 9px;
			height: 17px;
			line-height: 19px;
			position: absolute;
			right: 18px;
			text-align: center;
			top: -4px;
			width: 17px;
			margin-right: 15px;
		}
	</style>
</head>

<body>
	<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

	<!-- Body main wrapper start -->
	<div class="wrapper">
		<header id="htc__header" class="htc__header__area header--one">
			<div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
				<div class="container">
					<div class="row">
						<div class="menumenu__container clearfix">
							<div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">
								<div style="margin: -3px 10px 0 -10px;" class="logo">
									<svg data-v-423bf9ae="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 432 90" class="iconLeft">
										<!---->
										<a xlink:href="./index.php">
										<!---->
										<!---->
										<g data-v-423bf9ae="" id="8ae207ec-4e76-47fe-96b5-08fddd21fef6" fill="rgb(216, 90, 59)" transform="matrix(6.1412484328310715,0,0,6.1412484328310715,111.81626287613139,-3.3623326343138373)">
											<path d="M1.34 3.67L0.35 4.48L0.35 12.71L5.08 12.70L6.00 11.15L6.00 11.15Q4.99 11.64 1.60 11.47L1.60 11.47L1.60 8.38L3.97 8.38L4.70 7.25L1.64 7.25L1.64 4.79L4.81 4.79L5.65 3.66L1.34 3.67ZM8.05 3.60L6.73 4.16L6.73 12.74L8.05 12.14L8.05 3.60ZM10.99 3.55L9.72 4.14L9.72 5.58L10.99 5.06L10.99 3.55ZM10.99 6.54L9.68 7.02L9.68 12.67L10.99 12.21L10.99 6.54ZM13.65 3.55L12.33 4.01L12.33 12.72L13.73 12.24L13.74 9.77L13.74 9.77Q14 9.55 14.34 9.80L14.34 9.80L14.34 9.80Q14.68 10.06 15.47 11.33L15.47 11.33L15.47 11.33Q16.26 12.60 16.76 12.74L16.76 12.74L17.81 11.69L17.81 11.69Q17.30 11.50 16.57 10.34L16.57 10.34L16.57 10.34Q15.85 9.17 15.17 8.96L15.17 8.96L15.17 8.96Q15.93 8.52 16.55 7.87L16.55 7.87L16.55 7.87Q17.17 7.22 16.95 6.32L16.95 6.32L15.56 6.99L15.56 6.99Q15.63 7.82 15.15 8.38L15.15 8.38L15.15 8.38Q14.67 8.93 13.65 9.29L13.65 9.29L13.65 3.55ZM19.24 2.99L18.08 3.96L18.08 3.96Q18.60 4.38 18.66 4.88L18.66 4.88L18.66 4.88Q18.71 5.37 17.99 6.04L17.99 6.04L18.11 6.09L18.11 6.09Q19.54 5.19 19.78 4.75L19.78 4.75L19.78 4.75Q20.02 4.32 19.90 3.91L19.90 3.91L19.90 3.91Q19.78 3.51 19.55 3.26L19.55 3.26L19.55 3.26Q19.33 3.01 19.24 2.99L19.24 2.99ZM23.18 6.48L23.18 6.48L23.18 6.48Q22.48 6.57 22.10 6.79L22.10 6.79L22.10 6.79Q21.73 7.01 21.41 7.38L21.41 7.38L21.41 7.38Q21.10 7.76 21.08 8.38L21.08 8.38L21.08 8.38Q21.07 9.00 21.52 9.39L21.52 9.39L21.52 9.39Q21.96 9.77 23.24 10.21L23.24 10.21L23.24 10.21Q24.52 10.64 24.65 11.06L24.65 11.06L24.65 11.06Q24.79 11.48 24.47 11.76L24.47 11.76L24.47 11.76Q24.15 12.04 23.57 11.97L23.57 11.97L23.57 11.97Q22.99 11.90 22.56 11.61L22.56 11.61L22.56 11.61Q22.13 11.32 21.85 10.93L21.85 10.93L21.85 10.93Q21.57 10.55 21.51 10.27L21.51 10.27L20.45 11.06L20.45 11.06Q20.68 11.58 21.03 11.93L21.03 11.93L21.03 11.93Q21.38 12.28 21.91 12.50L21.91 12.50L21.91 12.50Q22.44 12.71 23.18 12.75L23.18 12.75L23.18 12.75Q23.93 12.78 24.50 12.37L24.50 12.37L24.50 12.37Q25.08 11.96 25.39 11.48L25.39 11.48L25.39 11.48Q25.70 11.01 25.68 10.52L25.68 10.52L25.68 10.52Q25.66 10.04 25.24 9.63L25.24 9.63L25.24 9.63Q24.83 9.21 23.46 8.75L23.46 8.75L23.46 8.75Q22.10 8.29 22.04 7.87L22.04 7.87L22.04 7.87Q21.98 7.44 22.52 7.29L22.52 7.29L22.52 7.29Q23.06 7.14 23.80 7.53L23.80 7.53L23.80 7.53Q24.54 7.93 24.49 8.16L24.49 8.16L25.35 7.25L25.35 7.25Q25.09 6.82 24.48 6.60L24.48 6.60L24.48 6.60Q23.88 6.39 23.18 6.48ZM33.27 6.50L33.27 6.50L33.27 6.50Q31.92 6.27 31.00 7.11L31.00 7.11L31.00 7.11Q30.07 7.96 29.88 9.11L29.88 9.11L29.88 9.11Q29.70 10.27 30.11 11.14L30.11 11.14L30.11 11.14Q30.53 12.02 31.23 12.37L31.23 12.37L31.23 12.37Q31.94 12.73 32.65 12.74L32.65 12.74L32.65 12.74Q33.37 12.76 34.03 12.16L34.03 12.16L34.03 12.16Q34.69 11.57 35.14 10.54L35.14 10.54L35.04 10.47L35.04 10.47Q34.10 11.42 33.24 11.47L33.24 11.47L33.24 11.47Q32.37 11.52 31.81 11.17L31.81 11.17L31.81 11.17Q31.26 10.82 30.92 10.13L30.92 10.13L30.92 10.13Q30.57 9.44 30.78 8.56L30.78 8.56L30.78 8.56Q30.98 7.67 31.63 7.39L31.63 7.39L31.63 7.39Q32.28 7.12 32.88 7.45L32.88 7.45L32.88 7.45Q33.49 7.78 33.74 8.78L33.74 8.78L34.94 7.99L34.94 7.99Q34.62 6.73 33.27 6.50ZM38.86 6.43L38.86 6.43L38.86 6.43Q37.95 6.36 36.93 6.88L36.93 6.88L36.93 6.88Q35.92 7.40 36.04 8.65L36.04 8.65L37.60 7.95L37.60 7.95Q37.49 7.10 38.23 6.96L38.23 6.96L38.23 6.96Q38.98 6.82 39.40 7.21L39.40 7.21L39.40 7.21Q39.81 7.61 39.75 8.80L39.75 8.80L39.75 8.80Q39.29 8.50 38.67 8.42L38.67 8.42L38.67 8.42Q38.06 8.33 37.04 8.85L37.04 8.85L37.04 8.85Q36.03 9.37 35.78 10.38L35.78 10.38L35.78 10.38Q35.53 11.38 36.31 12.06L36.31 12.06L36.31 12.06Q37.08 12.73 37.81 12.70L37.81 12.70L37.81 12.70Q38.53 12.67 38.90 12.39L38.90 12.39L38.90 12.39Q39.26 12.10 39.77 11.57L39.77 11.57L39.77 11.57Q39.76 12.44 39.97 12.76L39.97 12.76L41.32 12.04L41.32 12.04Q40.98 11.63 41.05 11.02L41.05 11.02L41.05 8.16L41.05 8.16Q41.08 7.49 40.43 6.99L40.43 6.99L40.43 6.99Q39.78 6.50 38.86 6.43ZM39.80 9.32L39.79 9.68L39.79 11.18L39.79 11.18Q38.62 12.11 37.68 11.55L37.68 11.55L37.68 11.55Q36.73 10.99 36.60 10.16L36.60 10.16L36.60 10.16Q36.48 9.34 37.42 9.31L37.42 9.31L37.42 9.31Q38.37 9.28 39.17 10.00L39.17 10.00L39.80 9.32ZM43.36 6.51L42.09 7.03L42.09 12.73L43.42 12.12L43.42 8.05L43.42 8.05Q44.06 7.22 44.65 7.37L44.65 7.37L44.65 7.37Q45.23 7.53 45.31 8.26L45.31 8.26L46.54 7.46L46.54 7.46Q46.40 6.62 45.39 6.50L45.39 6.50L45.39 6.50Q44.37 6.38 43.35 7.73L43.35 7.73L43.36 6.51ZM49.12 4.44L47.89 4.94L47.89 6.84L47.59 6.84L46.44 7.86L47.88 7.86L47.80 10.19L47.80 10.19Q47.81 11.87 48.69 12.42L48.69 12.42L48.69 12.42Q49.57 12.97 50.46 12.56L50.46 12.56L50.46 12.56Q51.35 12.15 51.67 11.09L51.67 11.09L51.58 10.93L51.58 10.93Q50.68 12.06 49.81 11.64L49.81 11.64L49.81 11.64Q48.93 11.22 49.08 9.78L49.08 9.78L49.13 7.85L49.97 7.85L52.04 6.79L49.12 6.79L49.12 4.44Z"></path>
										</g>
										<!---->
										<g data-v-423bf9ae="" id="67e16343-f10d-4669-8e1b-5a22ed5281b3" transform="matrix(1.9233588344097983,0,0,1.9233588344097983,-0.5110087102257168,-2.4801442529463387)" stroke="none" fill="rgb(216 201 59)">
											<path d="M42.187 30.881l-26.006 8.123M41.73 29.426l-26.004 8.117.911 2.918 26.006-8.123z"></path>
											<path d="M18.572 42.535a2.23 2.23 0 0 1-.513 1.664 2.253 2.253 0 0 1-1.539.814 2.277 2.277 0 1 1-1.969-3.723 2.25 2.25 0 0 1 1.542-.813 2.242 2.242 0 0 1 1.666.514c.47.388.756.935.813 1.544zm-2.764-5.101a5.322 5.322 0 0 0-3.609 1.91 5.309 5.309 0 0 0-1.201 3.9 5.342 5.342 0 0 0 5.807 4.811 5.279 5.279 0 0 0 3.605-1.908 5.275 5.275 0 0 0 1.204-3.898 5.289 5.289 0 0 0-1.907-3.607 5.301 5.301 0 0 0-3.899-1.208zM13.436 30.992l26.118 8.447M39.081 40.897L12.97 32.449l.94-2.907 26.113 8.448z"></path>
											<path d="M32.707 42.547a5.286 5.286 0 0 0 1.186 3.902 5.288 5.288 0 0 0 3.599 1.922 5.337 5.337 0 0 0 5.828-4.781 5.343 5.343 0 0 0-4.786-5.83 5.294 5.294 0 0 0-3.903 1.188 5.282 5.282 0 0 0-1.924 3.599zm5.529-1.752a2.287 2.287 0 0 1 2.044 2.494 2.29 2.29 0 0 1-2.491 2.049 2.301 2.301 0 0 1-1.538-.824 2.268 2.268 0 0 1-.505-1.674 2.27 2.27 0 0 1 .822-1.537 2.273 2.273 0 0 1 1.668-.508z"></path>
											<g>
												<path d="M11.115 19.867L5.497 2.681 5.155 1.64l-1.097-.01L.6 1.603.572 4.656l3.461.029L2.594 3.63l5.62 17.182z"></path>
											</g>
											<g>
												<path d="M17.158 26.744h20.74l2.869-7.362-25.697.092z"></path>
												<path d="M5.756 13.544L12.45 32.75l29.955-.223 7.022-18.983H5.756zm34.609 15.282l-.379.973H14.86l-.318-1.104-2.963-10.315-.558-1.939 2.021-.008 29.954-.109 2.243-.01-.815 2.088-4.059 10.424z"></path>
											</g>
											<g>
												<path clip-rule="evenodd" d="M32.577 11.763h3.868L32.577 8.57l-3.866-3.191-3.864 3.191-3.865 3.193h11.595z"></path>
											</g>
										</g>
										<!---->
										</a>
									</svg>
								</div>
							</div>
							<div class="col-md-7 col-lg-6 col-sm-5 col-xs-3">
								<nav class="main__menu__nav hidden-xs hidden-sm">
									<ul class="main__menu">
										<li class="drop"><a href="index.php">Home</a></li>
										<?php
										foreach ($cat_arr as $list) {
										?>
											<li class="drop"><a href="categories.php?id=<?php echo $list['id'] ?>"><?php echo $list['categories'] ?></a>
												<?php
												$cat_id = $list['id'];
												$sub_cat_res = mysqli_query($con, "select * from sub_categories where status='1' and categories_id='$cat_id'");
												if (mysqli_num_rows($sub_cat_res) > 0) {
												?>

													<ul class="dropdown">
														<?php
														while ($sub_cat_rows = mysqli_fetch_assoc($sub_cat_res)) {
															echo '<li><a href="categories.php?id=' . $list['id'] . '&sub_categories=' . $sub_cat_rows['id'] . '">' . $sub_cat_rows['sub_categories'] . '</a></li>
													';
														}
														?>
													</ul>
												<?php } ?>
											</li>
										<?php
										}
										?>
										<li><a href="contact.php">contact</a></li>
									</ul>
								</nav>

								<div class="mobile-menu clearfix visible-xs visible-sm">
									<nav id="mobile_dropdown">
										<ul>
											<li><a href="index.php">Home</a></li>
											<?php
											foreach ($cat_arr as $list) {
											?>
												<li class="drop"><a href="categories.php?id=<?php echo $list['id'] ?>"><?php echo $list['categories'] ?></a>
													<?php
													$cat_id = $list['id'];
													$sub_cat_res = mysqli_query($con, "select * from sub_categories where status='1' and categories_id='$cat_id'");
													if (mysqli_num_rows($sub_cat_res) > 0) {
													?>

														<ul class="dropdown">
															<?php
															while ($sub_cat_rows = mysqli_fetch_assoc($sub_cat_res)) {
																echo '<li><a href="categories.php?id=' . $list['id'] . '&sub_categories=' . $sub_cat_rows['id'] . '">' . $sub_cat_rows['sub_categories'] . '</a></li>
													';
															}
															?>
														</ul>
													<?php } ?>
												</li>
											<?php
											}
											?>
											<li><a href="contact.php">contact</a></li>
										</ul>
									</nav>
								</div>
							</div>
							<div class="col-md-3 col-lg-4 col-sm-4 col-xs-4">
								<div class="header__right">
									<?php
									$class = "mr15";
									if (isset($_SESSION['USER_LOGIN'])) {
										$class = "";
									}
									?>
									<div class="header__search search search__open <?php echo $class ?>">
										<a href="#"><i class="icon-magnifier icons"></i></a>
									</div>

									<div class="header__account">
										<?php if (isset($_SESSION['USER_LOGIN'])) {
										?>
											<nav class="navbar navbar-expand-lg navbar-light bg-light">
												<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
													<span class="navbar-toggler-icon"></span>
												</button>

												<div class="collapse navbar-collapse" id="navbarSupportedContent">
													<ul class="navbar-nav mr-auto">
														<li class="nav-item dropdown">
															<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																Hi <?php echo $_SESSION['USER_NAME'] ?>
															</a>
															<div class="dropdown-menu" aria-labelledby="navbarDropdown">
																<a class="dropdown-item" href="my_order.php">Order</a>
																<a class="dropdown-item" href="profile.php">Profile</a>
																<div class="dropdown-divider"></div>
																<a class="dropdown-item" href="logout.php">Logout</a>
															</div>
														</li>

													</ul>
												</div>
											</nav>
										<?php
										} else {
											echo '<a href="login.php" class="mr15">Login/Register</a>';
										}
										?>



									</div>
									<div class="htc__shopping__cart">
										<?php
										if (isset($_SESSION['USER_ID'])) {
										?>
											<a href="wishlist.php" class="mr15"><i class="icon-heart icons"></i></a>
											<a href="wishlist.php"><span class="htc__wishlist"><?php echo $wishlist_count ?></span></a>
										<?php } ?>
										<a href="cart.php"><i class="icon-handbag icons"></i></a>
										<a href="cart.php"><span class="htc__qua"><?php echo $totalProduct ?></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="mobile-menu-area"></div>
				</div>
			</div>
		</header>
		<div class="body__overlay"></div>
		<div class="offset__wrapper">
			<div class="search__area">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="search__inner">
								<form action="search.php" method="get">
									<input placeholder="Search here... " type="text" name="str">
									<button type="submit"></button>
								</form>
								<div class="search__close__btn">
									<span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>