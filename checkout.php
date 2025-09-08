<?php
require('top.php');
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
?>
	<script>
		window.location.href='index.php';
	</script>
	<?php
}

$cart_total = 0;

if (isset($_POST['submit'])) {
	include("./functions.php");
	$address = get_safe_value($con, $_POST['address']);
	$city = get_safe_value($con, $_POST['city']);
	$pincode = get_safe_value($con, $_POST['pincode']);
	$firstname = get_safe_value($con, $_POST['firstname']);
	$lastname = get_safe_value($con, $_POST['lastname']);
	$mobile = get_safe_value($con, $_POST['mobile']);
	$payment_type = get_safe_value($con, $_POST['payment_type']);
	$user_id = $_SESSION['USER_ID'];
	foreach ($_SESSION['cart'] as $key => $val) {
		$productArr = get_product($con, '', '', $key);
		$price = $productArr[0]['price'];
		$qty = $val['qty'];
		$cart_total = $cart_total + ($price * $qty);
	}
	$total_price = $cart_total;
	$payment_status = 'pending';
	if ($payment_type == 'MTN') {
		$payment_status = 'MTN';
	}elseif ($payment_type == 'VODAFONE') {
		$payment_status = 'VODAFONE';
	}elseif ($payment_type == 'AITELTIGO') {
		$payment_status = 'AITELTIGO';
	}
	$order_status = '1';
	$added_on = date('Y-m-d h:i:s');

	$clienttrid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

	if (isset($_SESSION['COUPON_ID'])) {
		$coupon_id = $_SESSION['COUPON_ID'];
		$coupon_code = $_SESSION['COUPON_CODE'];
		$coupon_value = $_SESSION['COUPON_VALUE'];
		$total_price = $total_price - $coupon_value;
		// unset($_SESSION['COUPON_ID']);
		// unset($_SESSION['COUPON_CODE']);
		// unset($_SESSION['COUPON_VALUE']);
	} else {
		$coupon_id = '';
		$coupon_code = '';
		$coupon_value = '';
	}
	
	
	$order_id = mysqli_insert_id($con);

	foreach ($_SESSION['cart'] as $key => $val) {
		$productArr = get_product($con, '', '', $key);
		$price = $productArr[0]['price'];
		$qty = $val['qty'];

		mysqli_query($con, "insert into `order_detail`(order_id,product_id,qty,price) values('$order_id','$key','$qty','$price')");
	}
	
	// unset($_SESSION['cart']);
	
	if (($payment_type == 'MTN') ||($payment_type == 'VODAFONE') || ($payment_type == 'AIRTELTIGO')) {
		$userArr = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `address` WHERE `user_id`='$user_id'"));
		$formError = 0;
		$posted['amount'] = $total_price;
		$posted['productinfo'] = "productinfo";
		if (is_countable($userArr) && count($userArr)>0) {
			$posted['firstname'] = $userArr['firstname'];
			$posted['lastname'] = $userArr['lastname'];
			$posted['email'] = $userArr['email'];
			$posted['mobile'] = $userArr['mobile'];
			$posted['address'] = $userArr['address'];
			$posted['city'] = $userArr['city'];
			$posted['pincode'] = $userArr['pincode'];
		}else{
			$userArr = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `users` WHERE `id`='$user_id'"));
			$posted['amount'] = $total_price;
			$posted['firstname'] = $firstname;
			$posted['lastname'] = $lastname;
			$posted['address'] = $address;
			$posted['city'] = $city;
			$posted['pincode'] = $pincode;
			$posted['email'] = $userArr['email'];
			$posted['mobile'] = $userArr['mobile'];
			insertAddress($user_id, $posted['address'], $posted['city'], $posted['pincode'], $posted['firstname'], $posted['lastname'], $posted['mobile'], $posted['email']);
		}
		$clienttrans = "Elikscart" . rand(100000, 999999);
        $clienttransid = $clienttrans;
		$action = "./checkout_process.php";
		insertTransaction($total_price, $posted['mobile'], $payment_type, $posted['email'], $clienttransid, $user_id);            
		
		
		$formHtml = '<form method="post" name="payuForm" id="payuForm" action="' . $action . '">
		<input type="hidden" name="amount" value="' . $posted['amount'] . '" />
		<input type="hidden" name="firstname" value="' . $firstname . '"/>
		<input type="hidden" name="lastname" value="' . $posted['lastname'] . '" />
		<input type="hidden" name="payment_type" value="' . $payment_type . '" />
		<input type="hidden" name="email" id="email" value="' . $posted['email'] . '" />
		<input type="hidden" name="mobile" value="' . $posted['mobile'] . '" />
		<textarea name="productinfo" style="display:none;">' . $posted['productinfo'] . '</textarea>
		<input type="hidden" name="surl" value="' . SITE_PATH . 'payment_complete.php" />
		<input type="hidden" name="furl" value="' . SITE_PATH . 'payment_fail.php"/>
		<input type="submit" style="display:none;"/>
		</form>';
		echo $formHtml;
		// echo '<script>document.getElementById("payuForm").submit();</script>';
	} else {
		
		?>
		<script>
			window.location.href = 'thank_you.php';
			</script>
<?php
	}
	mysqli_query($con, "insert into `order`(user_id,address,city,pincode,payment_type,payment_status,order_status,added_on,total_price,txnid,coupon_id,coupon_code,coupon_value) values('$user_id','$address','$city','$pincode','$payment_type','$payment_status','$order_status','$added_on','$total_price','$clienttransid','$coupon_id','$coupon_code','$coupon_value')");
}
?>

<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
	<div class="ht__bradcaump__wrap">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="bradcaump__inner">
						<nav class="bradcaump-inner">
							<a class="breadcrumb-item" href="index.php">Home</a>
							<span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
							<span class="breadcrumb-item active">checkout</span>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Bradcaump area -->
<!-- cart-main-area start -->
<div class="checkout-wrap ptb--100">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="checkout__inner">
					<div class="accordion-list">
						<div class="accordion">

							<?php
							$accordion_class = 'accordion__title';
							if (!isset($_SESSION['USER_LOGIN'])) {
								$accordion_class = 'accordion__hide';
							?>
								<div class="accordion__title">
									Checkout Method
								</div>
								<div class="accordion__body">
									<div class="accordion__body__form">
										<div class="row">
											<div class="col-md-6">
												<div class="checkout-method__login">
													<form id="login-form" method="post">
														<h5 class="checkout-method__title">Login</h5>
														<div class="single-input">
															<input type="text" name="login_email" id="login_email" placeholder="Your Email*" style="width:100%">
															<span class="field_error" id="login_email_error"></span>
														</div>

														<div class="single-input">
															<input type="password" name="login_password" id="login_password" placeholder="Your Password*" style="width:100%">
															<span class="field_error" id="login_password_error"></span>
														</div>

														<p class="require">* Required fields</p>
														<div class="dark-btn">
															<button type="button" class="fv-btn" onclick="user_login()">Login</button>
														</div>
														<div class="form-output login_msg">
															<p class="form-messege field_error"></p>
														</div>
													</form>
												</div>
											</div>
											<div class="col-md-6">
												<div class="checkout-method__login">
													<form action="#">
														<h5 class="checkout-method__title">Register</h5>
														<div class="single-input">
															<input type="text" name="name" id="name" placeholder="Your Name*" style="width:100%">
															<span class="field_error" id="name_error"></span>
														</div>
														<div class="single-input">
															<input type="text" name="email" id="email" placeholder="Your Email*" style="width:100%">
															<span class="field_error" id="email_error"></span>
														</div>

														<div class="single-input">
															<input type="text" name="mobile" id="mobile" placeholder="Your Mobile*" style="width:100%">
															<span class="field_error" id="mobile_error"></span>
														</div>
														<div class="single-input">
															<input type="password" name="password" id="password" placeholder="Your Password*" style="width:100%">
															<span class="field_error" id="password_error"></span>
														</div>
														<div class="dark-btn">
															<button type="button" class="fv-btn" onclick="user_register()">Register</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
							<div class="<?php echo $accordion_class ?>">
		
								Address Information
							</div>
							<form method="post">
								<div class="accordion__body">
									<div class="bilinfo">
									<?php
										$user_id = $_SESSION['USER_ID'];
											$userArr = mysqli_fetch_assoc(mysqli_query($con, "select * from address where user_id='$user_id'"));
											if (count($userArr)>0) {
												$posted['firstname'] = $userArr['firstname'];
												$posted['lastname'] = $userArr['lastname'];
												$posted['email'] = $userArr['email'];
												$posted['mobile'] = $userArr['mobile'];
												$posted['address'] = $userArr['address'];
												$posted['city'] = $userArr['city'];
												$posted['pincode'] = $userArr['pincode']; ?> 

												<div class="row" style="box-shadow:10px 10px 10px rgba(0,0,0,0.6); border-radius: 8px; width: 90%; margin: 0 auto; border: 1px solid whitesmoke;">
													<div class="col-md-12">
														<div class="col-md-6">Foster</div>
														<div class="col-md-6"><div style="position:absolute; right: 0;">Edit<a href="#accountedit"><i class="fa fa-edit"></i></a></div></div>
														<!-- <i class="fa fa-edit"></i> -->
													</div>
													<div class="col-md-12">
														<div class="single-input">Foster</div>
													</div>
													<div class="col-md-12">
														<div class="single-input">Foster</div>
													</div>
													<div class="col-md-12">
														<div class="single-input">Foster</div>
														<div class="single-input">Foster</div>
													</div>

														<input type="hidden" name="firstname" value="<?= $posted['firstname']; ?>" required>
														<input type="hidden" name="lastname" value="<?= $posted['lastname']; ?>" required>
														<input type="hidden" name="mobile" value="<?= $posted['mobile']; ?>" required>
														<input type="hidden" name="address" value="<?= $posted['address']; ?>" required>
														<input type="hidden" name="city" value="<?= $posted['city']; ?>" required>
														<input type="hidden" name="pincode" value="<?= $posted['pincode']; ?>" required>

										</div>
										

											<?php } else{
										?>

										<div class="row">
											<div class="col-md-6">
												<div class="single-input">
													<input type="text" name="firstname" placeholder="Firstname" required>
												</div>
											</div>
											<div class="col-md-6">
												<div class="single-input">
													<input type="text" name="lastname" placeholder="Lastname" required>
												</div>
											</div>
											<div class="col-md-12">
												<div style="display: flex; flex-direction: row; margin-top: 10px;" class="single-input">
													<div class="checkout-zip-code">+233</div>
													<input style="width: 90%;" type="text" name="mobile" placeholder="mobile Number" required>
												</div>
											</div>

											<div class="col-md-12">
												<div class="single-input">
													<input type="text" name="address" placeholder="Street Address" required>
												</div>
											</div>
											<div class="col-md-6">
												<div class="single-input">
													<input type="text" name="city" placeholder="City/State" required>
												</div>
											</div>
											<div class="col-md-6">
												<div class="single-input">
													<input type="text" name="pincode" placeholder="Post code/ zip" required>
												</div>
											</div>

										</div>
										<?php } ?>

									</div>
								</div>
								<div class="<?php echo $accordion_class ?>">
									payment information
								</div>
								<div class="accordion__body">
									<div class="paymentinfo">
										<div class="single-method">
											MTN <input type="radio" name="payment_type" value="MTN" required />
											&nbsp;&nbsp;VODAFONE <input type="radio" name="payment_type" value="VODAFONE" required />
											&nbsp;&nbsp;AIRTELTIGO <input type="radio" name="payment_type" value="AIRTELTIGO" required />
										</div>
										<div class="single-method">

										</div>
									</div>
								</div>
								<input type="submit" name="submit" class="fv-btn" />
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="order-details">
					<h5 class="order-details__title">Your Order</h5>
					<div class="order-details__item">
						<?php
						$cart_total = 0;
						foreach ($_SESSION['cart'] as $key => $val) {
							$productArr = get_product($con, '', '', $key);
							$pname = $productArr[0]['name'];
							$mrp = $productArr[0]['mrp'];
							$price = $productArr[0]['price'];
							$image = $productArr[0]['image'];
							$qty = $val['qty'];
							$cart_total = $cart_total + ($price * $qty);
						?>
							<div class="single-item">
								<div class="single-item__thumb">
									<img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $image ?>" />
								</div>
								<div class="single-item__content">
									<a href="#"><?php echo $pname ?></a>
									<span class="price"><?php echo $price * $qty ?></span>
								</div>
								<div class="single-item__remove">
									<a href="javascript:void(0)" onclick="manage_cart('<?php echo $key ?>','remove')"><i class="icon-trash icons"></i></a>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="ordre-details__total" id="coupon_box">
						<h5>Coupon Value</h5>
						<span class="price" id="coupon_price"></span>
					</div>
					<div class="ordre-details__total">
						<h5>Order total</h5>
						<span class="price" id="order_total_price"><?php echo $cart_total ?></span>
					</div>

					<div class="ordre-details__total bilinfo">
						<input type="textbox" id="coupon_str" class="coupon_style mr5" /> <input type="button" name="submit" class="fv-btn coupon_style" value="Apply Coupon" onclick="set_coupon()" />

					</div>
					<div id="coupon_result"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function set_coupon() {
		var coupon_str = jQuery('#coupon_str').val();
		if (coupon_str != '') {
			jQuery('#coupon_result').html('');
			jQuery.ajax({
				url: 'set_coupon.php',
				type: 'post',
				data: 'coupon_str=' + coupon_str,
				success: function(result) {
					var data = jQuery.parseJSON(result);
					if (data.is_error == 'yes') {
						jQuery('#coupon_box').hide();
						jQuery('#coupon_result').html(data.dd);
						jQuery('#order_total_price').html(data.result);
					}
					if (data.is_error == 'no') {
						jQuery('#coupon_box').show();
						jQuery('#coupon_price').html(data.dd);
						jQuery('#order_total_price').html(data.result);
					}
				}
			});
		}
	}
</script>
<?php
if (isset($_SESSION['COUPON_ID'])) {
	unset($_SESSION['COUPON_ID']);
	unset($_SESSION['COUPON_CODE']);
	unset($_SESSION['COUPON_VALUE']);
}
require('footer.php');
?>