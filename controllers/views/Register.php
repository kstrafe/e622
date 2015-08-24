<?php
	class Register
	{
		static function renderInformation()
		{
			return self::$information;
		}

		private static $information = '<div class="smalltext">Your email is used to send you a password reset. Your password is securely hashed and salted, so we can not retrieve it. Your username must be unique. The username can be changed.</div><div class="space vertical"></div>';

		static function renderReason($reason)
		{
			switch ($reason)
			{
				case 'no_username':
					$reason = 'A request was made for a new account, but no username was given.';
				break;
				case 'no_email':
					$reason = 'A request was made for a new account, but no email was given.';
				break;
				case 'no_password':
					$reason = 'A request was made for a new account, but no password was given.';
				break;
				case 'email_used':
					$reason = 'The email address is already used. If you lost your password <a href="reset"> click here </a>';
				break;
				case null:
					return '';
				break;
			}
			return self::$reason_code[0] . $reason . self::$reason_code[1];
		}

		static function render()
		{
			return self::$code;
		}

		static $reason_code =
		[
			'<div class="warning">',

			'</div>'
		];

		static private $code = '<div class="row">
						REGISTER
					</div>
					<div class="row">
						<span class="smalltext">
							We suggest using a password manager and to autogenerate the password with more than twenty characters.
						</span>
					</div>
					<form action="/checkregister" method="post">
						<div class="autotable">
							<div class="auto table-column"></div>
							<div class="tiny table-column"></div>
							<div class="max table-column"></div>
							<div class="row">
								<div class="cell">
									Username
								</div>
								<div class="cell"></div>
								<div class="cell">
									<input class="searchbar" name="username" placeholder="This is my username" type="text">
								</div>
							</div>
							<div class="row">
								<div class="cell">
									Email
								</div>
								<div class="cell"></div>
								<div class="cell">
									<input class="searchbar" name="email" placeholder="xXxN00bKill4r94oOo@rektmail.com" type="text">
								</div>
							</div>
							<div class="row">
								<div class="cell">
									Password
								</div>
								<div class="cell"></div>
								<div class="cell">
									<div class="table">
										<div class="row">
											<input class="searchbar" name="password" type="password">
										</div>
										<div class="row">
											<input class="searchbar" name="password_retype" type="password">
										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="submit" value="register">
					</form>';
	}
?>
