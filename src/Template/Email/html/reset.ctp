<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>TDTracStaff:: <?= $CONFIG['long-name'] ?></title>
		<style>
			@media only screen and (max-width: 620px) {
				table[class=body] h1 {
				font-size: 28px !important;
				margin-bottom: 10px !important;
				}
				table[class=body] p,
					table[class=body] ul,
					table[class=body] ol,
					table[class=body] td,
					table[class=body] span,
					table[class=body] a {
				font-size: 16px !important;
				}
				table[class=body] .wrapper,
					table[class=body] .article {
				padding: 10px !important;
				}
				table[class=body] .content {
				padding: 0 !important;
				}
				table[class=body] .container {
				padding: 0 !important;
				width: 100% !important;
				}
				table[class=body] .main {
				border-left-width: 0 !important;
				border-radius: 0 !important;
				border-right-width: 0 !important;
				}
				table[class=body] .btn table {
				width: 100% !important;
				}
				table[class=body] .btn a {
				width: 100% !important;
				}
				table[class=body] .img-responsive {
				height: auto !important;
				max-width: 100% !important;
				width: auto !important;
				}
			}

			@media all {
				.ExternalClass {
					width: 100%;
				}
				.ExternalClass,
					.ExternalClass p,
					.ExternalClass span,
					.ExternalClass font,
					.ExternalClass td,
					.ExternalClass div {
				line-height: 100%;
				}
				.apple-link a {
				color: inherit !important;
				font-family: inherit !important;
				font-size: inherit !important;
				font-weight: inherit !important;
				line-height: inherit !important;
				text-decoration: none !important;
				}
				#MessageViewBody a {
				color: inherit;
				text-decoration: none;
				font-size: inherit;
				font-family: inherit;
				font-weight: inherit;
				line-height: inherit;
				}
				.btn-primary table td:hover {
				background-color: #34495e !important;
				}
				.btn-primary a:hover {
				background-color: #34495e !important;
				border-color: #34495e !important;
				}
			}
		</style>
	</head>
	<body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
	<table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
		<tr>
		<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
		<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
			<div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

			<!-- START CENTERED WHITE CONTAINER -->
			<span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">Important information from <?= $CONFIG['long-name'] ?></span>
			<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

				<tr><td style="font-family: sans-serif; font-weight: bold; font-size: 24px; vertical-align: top; box-sizing: border-box; padding: 20px; background-color: #8606c7; color:white;">TDTracStaff::<?= $CONFIG['long-name'] ?></td></tr>
				<!-- START MAIN CONTENT AREA -->
				<tr>
				<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
					<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
					<tr>
						<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
						
						<h3>Password reset requested!</h3>

						<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Your, or someone else from a computer at <strong><?= $ip ?></strong> has requested a password reset for <strong><?= $username ?></strong>.</p>

						<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">To reset your password please go to <a href="<?= $fullURL . $hash ?>"><?= $fullURL . $hash ?></a> before <strong><?= $expire ?></strong>.</p>

						<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">If you did not request this action, please just ignore this e-mail.  It was only sent to your address, and you should not assume your account has been compromised. If you are still concerned, logging in normally will clear this temporary reset link.</p>

						</td>
					</tr>
					</table>
				</td>
				</tr>

			<!-- END MAIN CONTENT AREA -->
			</table>

			<!-- START FOOTER -->
			<div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
				<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
				<tr>
					<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
					You are recieving this e-mail because your are an employee of <?= $CONFIG['long-name'] ?>.<br>Please contact
					your supervisor or administrator to no longer receive messages.<br><br>
					<span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;"><?= $CONFIG['mailing-address'] ?></span>
					<br> Don't like these emails? <a href="mailto:<?= $CONFIG['admin-email'] ?>?subject=Unsubscribe&body=I%20hate%20e-mails%2C%20please%20fire%20me%3F" style="text-decoration: underline; color: #999999; font-size: 12px; text-align: center;">Unsubscribe</a>.
					</td>
				</tr>
				<tr>
					<td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 0px; font-size: 12px; color: #999999; text-align: center;">
					Powered by <a href="http://tdtrac.com" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">TDTracStaff</a>.
					</td>
				</tr>
				</table>
			</div>
			<!-- END FOOTER -->

			<!-- END CENTERED WHITE CONTAINER -->
			</div>
		</td>
		<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
		</tr>
	</table>
	</body>
</html>
