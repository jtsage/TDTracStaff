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

		<link href="/favicon.ico" type="image/x-icon" rel="icon"/><link href="/favicon.ico" type="image/x-icon" rel="shortcut icon"/>
		<meta name="apple-mobile-web-app-title" content="TDTracStaff">
		<meta name="application-name" content="TDTracStaff">
		<meta name="theme-color" content="#ffffff">

		<?php

			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		
			echo $this->Html->css('https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css');
			echo $this->Html->css('bootstrap.min.css');
			echo $this->Html->css('bootstrap4-toggle.min.css');
			
			echo $this->Html->css('typeaheadjs.min.css');
			echo $this->Html->css('Chart.min.css');
			echo $this->Html->css('tdtracx');
			

		?>
		<?php
			echo $this->Html->script('jquery-3.3.1.min.js');
			echo $this->Html->script('typeahead.bundle.min.js');
			echo $this->Html->script('bootstrap4-toggle.min.js');

			echo $this->Html->script('popper.min.js');

			echo $this->Html->script('bootstrap.min.js');
			echo $this->Html->script('bootbox.min.js');
			echo $this->Html->script('jtsage-datebox.min.js');
			echo $this->Html->script('Chart.min.js');
			echo $this->Html->script("gauge.min.js");
			echo $this->Html->script('tdtrac-staffer');
			
		?>

	</head>
	<body>
	<div class="wrapper">
		<!-- Sidebar  -->
		<nav id="sidebar">
			<div class="sidebar-header">
				<h3 class="mb-0 pb-0 text-white">TDTrac<span style="color:#C3593C">Staff</span</h3>
			</div>

			<ul class="list-unstyled components">
				<li class="<?= ($this->request->getParam('controller') == "Pages" ? " active":"") ?>">
					<a href="/"><?= $this->HtmlExt->icon("view-dashboard") ?> Dashboard</a>
				</li>
				<li class="<?= ($this->request->getParam('controller') == "Jobs" ? " active":"") ?>">
					<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><?= $this->HtmlExt->icon("worker") ?> Jobs</a>
					<ul class="collapse list-unstyled" id="homeSubmenu">
						<?php if ($WhoAmI) : ?>
							<li class="border-bottom border-dark"><a href="/jobs/">All Jobs</a></li>
						<?php endif; ?>
						<li><a href="/jobs/myrespond/">Jobs Awaiting Availability Response</a></li>
						<li><a href="/jobs/myjobs/">My Qualified Jobs</a></li>
						<li class="border-bottom border-dark"><a href="/jobs/mysched/">My Scheduled Jobs</a></li>
						<li><a href="/jobs/calendar/">Calendar</a></li>
						<li><a href="/jobs/day/">Today</a></li>
					</ul>
				</li>
				<li><a href="/payrolls/add/"><?= $this->HtmlExt->icon("alarm-plus") ?> <?= __("Add Payroll") ?></a></li>
				<li class="<?= ($this->request->getParam('controller') == "Payrolls" ? " active":"") ?>">
					<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><?= $this->HtmlExt->icon("cash") ?> Payroll</a>
					<ul class="collapse list-unstyled" id="pageSubmenu">
						<li><a class="<?= (!$WhoAmI)?"border-bottom":"" ?> border-dark" href="/payrolls/add/">Add Hours</a></li>
						
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

				<?= ($WhoAmI) ? "<li class='" . ($this->request->getParam('controller') == "Roles" ? "active":"") . "'><a href=\"/roles/\">{$this->HtmlExt->icon("account-star")} Worker Titles</a></li>" : "" ?>

				<li class="<?= ($this->request->getParam('controller') == "Users" ? "active":"") ?>"><a href="/users/"><?= ($WhoAmI) ? $this->HtmlExt->icon("account-group") . " Users" : $this->HtmlExt->icon("account") . " My Account" ?></a></li>
				
				<?= ($WhoAmI) ? "<li class='" . ($this->request->getParam('controller') == "AppConfigs" ? "active":"") . "'><a href=\"/app-configs/\">{$this->HtmlExt->icon("settings")} Configuration</a></li>" : "" ?>

				<li><a href="/users/logout/"><?= $this->HtmlExt->icon("logout") ?> <?= __("Logout") ?></a></li>

			</ul>

			<ul class="list-unstyled CTAs">
				<li>
					<a class="article" onClick="javascript:$('#helpMeModal').modal(); return false;" href="#">Online Help</a></li>
					
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
						<li class="list-inline-item"><?= __('Currently v0.0.0a1') ?></li>
						<li class="list-inline-item"><a href="https://github.com/jtsage/TDTracStaff">GitHub</a></li>
					</ul>
				</footer>
				<footer class="d-print-block d-none" style="padding-top: 20px; margin-top: 20px; border-top: 1px solid #e5e5e5;">
					<p class="text-center text-muted">Printed on <?= date('Y-m-d H:i T') ?></p>
				</footer>
			</div>
		</div>
	</div>

	
	<div class="overlay loading"></div>
	<div class="spinner loading"></div>
	
	<script type="text/javascript">
	$(document).ready(function () {
		$('#due_payroll_paid-dbox').datebox({
			highDatesRec    : <?= $CONFIG["paydates-fixed"] ?>,
			highDatesPeriod : <?= $CONFIG["paydates-period"] ?>,
		});
	});
	</script>
	</body>
</html>
