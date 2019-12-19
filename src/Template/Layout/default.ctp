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


if ( $this->request->getParam('controller') == "Pages" ) {
	$cakeDescription = 'TDTracStaff: the theater time and job tracker '. $CONFIG['long-name'];
} else {
	$cakeDescription = 'TDTracStaff:' . $CONFIG['short-name'] . ":" . $this->fetch('title');
}

$user = $this->request->getSession()->read('Auth.User');

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?= $this->Html->charset() ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title><?= $cakeDescription ?></title>

		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
		<link rel="manifest" href="/site.webmanifest">
		<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="apple-mobile-web-app-title" content="TDTrac">
		<meta name="application-name" content="TDTrac">
		<meta name="msapplication-TileColor" content="#2b5797">
		<meta name="theme-color" content="#ffffff">

		<?php

			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		
			echo $this->Html->css("main.min.css");
			// echo $this->Html->css([
			// 	'materialdesignicons.min.css',
			// 	'bootstrap.min.css',
			// 	'bootstrap4-toggle.min.css',
			// 	'typeaheadjs.min.css',
			// 	'Chart.min.css',
			// 	'tdtracx.css'
			// ]);

			echo $this->Html->script("main.min.js");
			// echo $this->Html->script([
			// 	'jquery-3.3.1.min.js',
			// 	'typeahead.bundle.min.js',
			// 	'bootstrap4-toggle.min.js',
			// 	'popper.min.js',
			// 	'bootstrap.min.js',
			// 	'bootbox.min.js',
			// 	'jtsage-datebox.min.js',
			// 	'Chart.min.js',
			// 	"gauge.min.js",
			// 	'tdtrac-staffer.js'
			// ]);
			
		?>
		<style>
		@media print {
			.btn, .btn-group, .btn-group-sm-vertical, .btn-group-vertical { display: none; }
			.shadow-sm, .shadow { -webkit-box-shadow: none !important; box-shadow: none !important; }
		}
		</style>

	</head>
	<body>
	<div class="wrapper">
		<!-- Sidebar  -->
		<nav class="d-print-none" id="sidebar">
			<div class="sidebar-header">
				<h3 class="mb-0 pb-0 text-white">TDTrac<span style="color:#C3593C">Staff</span><span style="color:#ea975b"><?= $CONFIG["short-name"] ?></span></h3>
			</div>

			<?php 
				$thisCon = $this->request->getParam('controller');
				$thisAct = $this->request->getParam('action');
			?>

			<ul class="list-unstyled components">
				<li class="<?= ($thisCon == "Pages" ? " active":"") ?>">
					<a href="/"><?= $this->HtmlExt->icon("view-dashboard") ?> Dashboard</a>
				</li>

				<li class="<?= ($thisCon == "Jobs" && $thisAct == ( $WhoAmI ? "index":"myjobs" ) ? " active":"") ?>">
					<a href="/jobs/"><?= $this->HtmlExt->icon("worker") ?> <?= ( $WhoAmI ) ? "Open Jobs" : "Qualified Jobs" ?></a>
				</li>

				<li class="<?= ($thisCon == "Jobs" && !in_array($thisAct, ["calendar",( $WhoAmI ? "index":"myjobs" )]) ? " active":"") ?>">
					<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><?= $this->HtmlExt->icon("worker") ?> Jobs</a>
					<ul class="collapse list-unstyled" id="homeSubmenu">
						<li><a href="/jobs/myrespond/">Awaiting Response</a></li>
						<li><a href="/jobs/myjobs/">My Qualified Jobs</a></li>
						<li class="border-bottom border-dark"><a href="/jobs/mysched/">My Scheduled Jobs</a></li>
						<?php if ($WhoAmI) : ?>
							<li><a href="/jobs/short/">All Jobs, Concise</a></li>
							<li><a href="/jobs/inact/">Open and Inactive Jobs</a></li>
							<li class="border-bottom border-dark"><a href="/jobs/closed/">Closed Jobs</a></li>
							<li><a href="/jobs/today/">Today's Jobs</a></li>
							<li><a href="/jobs/tomorrow/">Tomorrow's Jobs</a></li>
							<li><a href="/jobs/yesterday/">Yesterday's Jobs</a></li>
							<li><a href="/jobs/week/">This Week's Jobs</a></li>
						<?php endif; ?>
					</ul>
				</li>

				<li class="<?= ($thisCon == "Jobs" && $thisAct == "calendar" ? " active":"") ?>">
					<a href="/jobs/calendar/"><?= $this->HtmlExt->icon("calendar") ?> Calendar</a>
				</li>

				<li class="<?= ($thisCon == "Payrolls" && $thisAct == "add" ? " active":"") ?>">
					<a href="/payrolls/add/"><?= $this->HtmlExt->icon("alarm-plus") ?> <?= __("Add Payroll") ?></a>
				</li>

				<li class="<?= ($thisCon == "Payrolls" && $thisAct <> "add" ? " active":"") ?>">
					<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><?= $this->HtmlExt->icon("cash") ?> Payroll</a>
					<ul class="collapse list-unstyled" id="pageSubmenu">
						<?php if ($WhoAmI) : ?>
							<li><a class="border-bottom border-dark" href="/payrolls/add-force/">Force Add Hours</a></li>

							<li><a href="/payrolls/">All Hours</a></li>
							<li><a class="border-bottom border-dark" href="/payrolls/unpaid">All Unpaid Hours</a></li>

							<li><a href="/payrolls/paydate/">Search by Paydate</a></li>
							<li><a class="border-bottom border-dark" href="/payrolls/dates/">Search by Date</a></li>

							<li><a href="/payrolls/by-user/">Search by User</a></li>
							
						<?php endif; ?>
						<li><a class="border-bottom border-dark" href="/payrolls/by-job/">Search by Job</a></li>

						<li><a href="/payrolls/mine/">My Hours</a></li>
						<li><a class="border-bottom border-dark" href="/payrolls/mine/unpaid/">My Unpaid Hours</a></li>

						<li><a href="/payrolls/mypaydate/">My Hours by Paydate</a></li>
						<li><a href="/payrolls/mydates/">My Hours by Date</a></li>
					</ul>
				</li>

				<?= ($BudgetAmI) ? "<li class='" . ($thisCon == "Budgets" ? "active":"") . "'><a href=\"/budgets/\">{$this->HtmlExt->icon("credit-card")} Budgets</a></li>" : "" ?>

				<li class="<?= ($thisCon == "Users" ? "active":"") ?>"><a href="/users/"><?= ($WhoAmI) ? $this->HtmlExt->icon("account-group") . " Users" : $this->HtmlExt->icon("account") . " My Account" ?></a></li>
				
				<?php if ( $WhoAmI ) : ?>
					<li class="<?= ($thisCon == "Roles" || $thisCon == "AppConfigs" || $thisCon == "MailQueues" ? " active":"") ?>">
						<a href="#confSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><?= $this->HtmlExt->icon("settings") ?> Settings</a>
						<ul class="collapse list-unstyled" id="confSubmenu">
							<li><a href="/roles/">Worker Titles</a></li>
							<li><a href="/app-configs/">Configuration</a></li>
							<?php if ( $CONFIG["queue-email"] ) : ?>
								<li>
									<a href="/mail-queues/">E-Mail Outbox <?= ( $MAILQUEUE > 0 ? "<span class=\"badge badge-warning float-right mt-1\">{$MAILQUEUE}</span>" : "" ) ?></a>
								</li>
							<?php endif; ?>
						</ul>
					</li>
				<?php endif; ?>

				<li><a href="/users/logout/"><?= $this->HtmlExt->icon("logout") ?> <?= __("Logout") ?></a></li>

			</ul>

			<ul class="list-unstyled CTAs">
				<li>
					<a class="article" onClick="javascript:$('#helpMeModal').modal(); return false;" href="#">Online Help</a>
				</li>
				<?php if ( $WhoAmI ) : ?>
				<li>
					<a class="article" target="_blank" href="https://demostaff.tdtrac.com/books/admin-handbook.pdf">Administrator Handbook</a>
				</li>
				<?php endif; ?>
				<li>
					<a class="article" target="_blank" href="https://demostaff.tdtrac.com/books/handbook.pdf">User Handbook</a>
				</li>
			</ul>

			
		</nav>

		<!-- Page Content  -->
		<div id="content" class="bg-light">
			<nav class="navbar navbar-expand-lg navbar-light mb-0" style="background-color:#2A3F54; height: 71px;">
				<div class="container-fluid">

					<button type="button" id="sidebarCollapse" class="btn btn-light">
						<?= $this->HtmlExt->icon("menu") ?>
						<span>Toggle Sidebar</span>
					</button>
					
						<ul class="nav navbar-nav ml-auto">
							<li class="nav-item text-white">
								<?php if( ! empty( $user ) ) : ?>
									<?= $this->HtmlExt->gravatar($user['username'],38) ?>
									<span class="d-none d-md-inline">
										 <?= $user['first'] ?> <?= $user['last'] ?>
									</span>
								<?php else : ?>
									Please sign in.
								<?php endif; ?>
							</li>
						</ul>
				</div>
			</nav>

			<div class="p-1 p-md-3">
				
				<?php if ( !empty($crumby) && is_array($crumby) ) : ?>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb bg-white border shadow-sm">
							<?php foreach ( $crumby as $crumb ) : ?>
								<?php if ( is_null($crumb[0]) ) : ?>
									<li class="breadcrumb-item active"><?= $crumb[1] ?></li>
								<?php else : ?>
									<li class="breadcrumb-item"><a href="<?= $crumb[0] ?>"><?= $crumb[1] ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ol>
					</nav>
				<?php endif; ?>

				<?= $this->Flash->render() ?>

				<?= $this->fetch('content') ?>
			
			
				<footer class="d-print-none" style="padding-top: 20px; margin-top: 20px; border-top: 1px solid #e5e5e5;">
					<p class="text-center text-muted"><?= __("TDTracStaff - the Theater time and job tracker") ?><br /><small>Site Administrator Contact: <a href="mailto:<?= $CONFIG['admin-email'] ?>"><?= $CONFIG['admin-name'] ?></a></small></p>
					<ul class="text-center list-inline text-muted d-print-none">
						<li class="list-inline-item"><?= __('Currently v1.0.2') ?></li>
						<li class="list-inline-item"><a href="https://github.com/jtsage/TDTracStaff">GitHub</a></li>
					</ul>
				</footer>
				<footer class="d-print-block d-none" style="padding-top: 20px; margin-top: 20px; border-top: 1px solid #e5e5e5;">
					<?php $print = new \DateTime("now", new \DateTimeZone($CONFIG['time-zone']) ); ?>
					<p class="text-center text-muted">Printed on <?= $print->format('Y-m-d h:ia T') ?></p>
				</footer>
			</div>
		</div>
	</div>

	
	<div class="overlay loading"></div>
	<div class="spinner loading"></div>
	
	<script>
	$(document).ready(function () {
		$('#due_payroll_paid-dbox').datebox({
			highDatesRec    : <?= $CONFIG["paydates-fixed"] ?>,
			highDatesPeriod : <?= $CONFIG["paydates-period"] ?>,
		});
	});
	</script>
	</body>
</html>
