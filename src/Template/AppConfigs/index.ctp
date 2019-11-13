<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppConfig[]|\Cake\Collection\CollectionInterface $appConfigs
 */
?>

<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4"><?= __("Application Config") ?></h3>
	<p class='text-dark'>This display shows all of the available configuration options for the running application.</p>
</div>

<div class="card rounded border shadow-sm">
	<table class="table table-striped table-bordered mb-0" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th scope="col">Setting Name</th>
				<th scope="col">Description</th>
				<th scope="col" class="text-center"><?= __('Actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($appConfigs as $appConfig): ?>
			<tr>
				<td class="align-middle"><?= h($appConfig->key_name) ?></td>
				<td class="align-middle"><?= h($appConfig->value_short) ?></td>
				<td class="actions"><div class="btn-group btn-group-sm-vertical w-100" role="group">
					<?= $this->HtmlExt->iconBtnLink(
						"eye-outline", "View",
						['action' => 'view', $appConfig->id],
						['class' => 'btn btn-outline-dark btn-sm w-100 text-left text-md-center']
					); ?>
						
					<?= $this->HtmlExt->iconBtnLink(
						"playlist-edit", "Edit",
						['action' => 'edit', $appConfig->id],
						['class' => 'btn btn-outline-success btn-sm w-100 text-left text-md-center']
					) ?>
				</div></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?= $this->Pretty->helpMeStart("Topic Unavailable"); ?>

<p>Use this screen to configure the application. See below for how each key works.</p>

<?= $this->Pretty->helpMeFld("admin-email", "Administrator's E-Mail Address"); ?>
<?= $this->Pretty->helpMeFld("admin-name", "Administrator's Full Name"); ?>
<?= $this->Pretty->helpMeFld("job-new-email", "Template for email's sent when a job is newly added to the database and needs staff to indicate availability. {{Variables}} are substituted for configuration values, [[variables]] are substituted for job details."); ?>
<?= $this->Pretty->helpMeFld("job-old-email", "Template for email's sent when a job is NOT newly added to the database and either STILL needs staff to indicate availability, or staffing needs have changed.  See above for variable expansion."); ?>
<?= $this->Pretty->helpMeFld("long-name", "Long name of the system, usually a company name"); ?>
<?= $this->Pretty->helpMeFld("mailing-address", "Mailing address of the company - make e-mails less spammy.  Set correctly."); ?>
<?= $this->Pretty->helpMeFld("notify-email", "Email sent when you have scheduled 1 or more staff members. {{Variables}} are substituted for configuration values, [[variables]] are substituted for job details."); ?>
<?= $this->Pretty->helpMeFld("paydates-fixed", "Set of fixed paydate, in the fixed format: [ [-1,-1,15], [-1,-1,30] ] (15th and 30th) or false -  - for details, see https://datebox.jtsage.dev :: highDatesRec"); ?>
<?= $this->Pretty->helpMeFld("paydates-period", "Set of period paydate, in the format [ \"2019-09-11\", 14 ] (start, period) or false - for details, see https://datebox.jtsage.dev :: highDatesPeriod"); ?>
<?= $this->Pretty->helpMeFld("require-hours", "Require hours worked, rather than just a total - must be 0 (use a total), or 1 (use start and end times)"); ?>
<?= $this->Pretty->helpMeFld("server-name", "FQDN, with protocol of the server name (https://example.net)"); ?>
<?= $this->Pretty->helpMeFld("short-name", "Short name of the Site, usually Initials"); ?>
<?= $this->Pretty->helpMeFld("welcome-email", "The welcome E-Mail. {{Variables}} are substituted for configuration values. For sending username and password automatically, include \"Username: \" and \"Password: \" on individual lines."); ?>

<p class="mt-4"><strong>WARNING: </strong>It is intentionally difficult to add new keys.  You can royally screw up the running system by adding values needlessly</p>
<?= $this->Pretty->helpMeEnd(); ?>