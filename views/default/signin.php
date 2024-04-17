<?php
require_once 'vendor/autoload.php';

// Khởi động session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cấu hình cho Google Client
$clientID = '626853522820-3glovi7qcqi6rckg1ev6ltq1oe56do5r.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/WBH_MVC/index/signin';

// Tạo Client Request để truy cập Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Xác thực mã từ Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Lấy thông tin profile
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;

    // Tại đây, bạn có thể tiến hành đăng nhập hoặc tạo tài khoản mới dựa trên thông tin nhận được
    // Đây chỉ là ví dụ, bạn cần phải kiểm tra xem người dùng đã tồn tại trong hệ thống của bạn chưa và xử lý theo
    $_SESSION['current_user'] = [
        'email' => $email,
        'name' => $name
    ];

    // Chuyển hướng người dùng đến trang chủ hoặc trang hồ sơ
    header('Location: http://localhost/WBH_MVC/'); // Đường dẫn chính xác đến trang chủ của ứng dụng
    exit;
} else {
    $loginUrl = $client->createAuthUrl();
}
?>

<!-- Phần HTML để hiển thị form đăng nhập -->
<div class="errorMes"></div>
<div class="container-fluid form" style="padding: 20px">
    <!-- ... phần còn lại của HTML ... -->
</div>


<!-- Phần HTML để hiển thị form đăng nhập -->
<div class="errorMes"></div>
<div class="container-fluid form" style="padding: 20px">
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<form action="" method="POST" role="form">
				<legend>Đăng Nhập</legend>

				<div class="form-group">
					<label for="">Tên tài khoản: </label>
					<input type="text" class="form-control" name="username" id="username">
				</div>
				<div class="form-group">
					<label for="">Mật khẩu: </label>
					<input type="password" class="form-control" name="password" id="password">
				</div>
				<input type="checkbox" id="rmbme" value="rl"><label> Nhớ tài khoản</label><br>

				<div class="btn btn-primary" id="loginBtn">Submit</div><br><br>
				<h2>Hoặc đăng nhập với:</h2>
                    <a href="<?= $loginUrl ?>"><img src="./images/google.png" alt='Google login' title="Google Login" height="50" width="280" /></a>

                    <input type="checkbox" id="rmbme" name="remember_me"><label for="rmbme"> Nhớ tài khoản</label><br>
                    <a href="forgot-password.php" style="float: right;">Quên mật khẩu?</a><br>
                    <a href="index/signup" style="float: right;">Tạo tài khoản mới</a><br><br>
                </form>
            <?php  ?>
				<!-- <input class="btn btn-primary" type="submit" value="Submit"><br><br> -->
				<a style="float: right;" class="abc">Quên mật khẩu?</a><br>
				<a href="index/signup" style="float: right;">Tạo tài khoản mới</a><br><br>
			</form>
		</div>
		<div class="col-lg-12"></div>
	</div>
</div>
