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
			
			 echo $this->Html->css('bootstrap.min.css');
			 echo $this->Html->css('bootstrap-switch.min');
			 echo $this->Html->css('tdtracx');
			 echo $this->Html->css('typeaheadjs.min.css');
			 echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');

		?>
		<?php
			echo $this->Html->script('jquery-3.3.1.slim.min.js');
			echo $this->Html->script('typeahead.bundle.min.js');
			echo $this->Html->script('bootstrap-switch.min');

			echo $this->Html->script('popper.min.js');

			echo $this->Html->script('bootstrap.min.js');
			echo $this->Html->script('validator.min');
			echo $this->Html->script('jtsage-datebox.min.js');
			echo $this->Html->script('tdtrac-staffer');
		?>

	</head>
	<body>

	<nav class="py-0 navbar navbar-expand-lg navbar-light bg-light">
		<a href="/" class="navbar-brand">TDTrac<span style="color:#C3593C">Staff</span><span style="color:#c39b1f"><?= $CONFIG['short-name']?></span></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item <?= ($this->request->getParam('controller') == "Jobs" ? " active":"") ?> dropdown">
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Jobs<span class="caret"></span></a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="/jobs/">All Jobs</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="/jobs/myjobs/">My Qualified Jobs</a>
						<a class="dropdown-item" href="/jobs/mysched/">My Scheduled Jobs</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="/jobs/calendar/">Calendar</a>
						<a class="dropdown-item" href="/jobs/day/">Today</a>
					</div>
				</li>
				<li class="nav-item <?= ($this->request->getParam('controller') == "Payrolls" ? " active":"") ?>"><a class="nav-link" href="/payrolls/"><?= __("Hours") ?></a></li>
				<?= ($WhoAmI) ? "<li class='nav-item" . ($this->request->getParam('controller') == "Roles" ? " active":"") . "'><a class=\"nav-link\" href=\"/roles/\">Worker Titles</a></li>" : "" ?>
				<li class="nav-item <?= ($this->request->getParam('controller') == "Users" ? " active":"") ?>"><a class="nav-link" href="/users/"><?= ($WhoAmI) ? __("Users") : __("My Account") ?></a></li>
				<?= ($WhoAmI) ? "<li class='nav-item" . ($this->request->getParam('controller') == "AppConfigs" ? " active":"") . "'><a class=\"nav-link\" href=\"/app-configs/\">Configuration</a></li>" : "" ?>
				<li class="nav-item"><a class="nav-link" href="/users/logout/"><?= __("Logout") ?></a></li>
			</ul>
			<?php 
				$user = $this->request->getSession()->read('Auth.User');

				if( ! empty( $user ) ) {
					echo '<span class="navbar-text navbar-right">' . __("Signed in") . ': ' . $user['first'] . " " . $user['last'] . ' </span>';
				}
			?>
		</div>
	</nav>


	<div class="container" style="padding-top:20px" role="main">

		<?php 
			if ( !empty($crumby) && is_array($crumby) ) {
				echo '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
				foreach ( $crumby as $crumb ) {
					if ( is_null($crumb[0]) ) {
						echo "<li class='breadcrumb-item active'>" . $crumb[1] . "</li>";
					} else {
						echo "<li class='breadcrumb-item'><a href='" . $crumb[0] . "'>" . $crumb[1] . "</a></li>";
					}
				}
				echo '</ol></nav>';
			}
		?>

		<?= $this->Flash->render() ?>

		<?= $this->fetch('content') ?>
	
	</div>
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

	
	<div class="overlay loading"></div>
	<div class="spinner loading"></div>
	
	</body>
</html>
