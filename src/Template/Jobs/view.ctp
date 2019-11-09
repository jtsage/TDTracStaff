<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 */
?>

<h4><?= $job->name ?></h4>
<div class="btn-group w-100 mb-2">
<?= $this->Html->link(
	$this->Pretty->iconTUp($job->id) . 'My Availability',
	['action' => 'available', $job->id],
	['escape' => false, 'class' => 'btn btn-sm btn-outline-warning']
) ?>
<?= $this->Html->link(
	$this->Pretty->iconUnpaid($job->id) . 'My Hours',
	['controller' => 'hours', 'action' => 'add-to-job', $job->id],
	['escape' => false, 'class' => 'btn btn-sm btn-outline-warning']
) ?>
<?php if ($WhoAmI) : ?>
<?= $this->Html->link(
	$this->Pretty->iconPrint($job->id) . 'Print Scheduled',
	['action' => 'print', $job->id],
	['escape' => false, 'class' => 'btn btn-sm btn-outline-dark']
) ?>
<?= $this->Html->link(
	$this->Pretty->iconSNeed($job->id) . 'Staff Needed',
	['action' => 'staffNeed', $job->id],
	['escape' => false, 'class' => 'btn btn-sm btn-outline-info']
) ?>
<?= $this->Html->link(
	$this->Pretty->iconSAssign($job->id) . 'Staff Assigned',
	['action' => 'staffAssign', $job->id],
	['escape' => false, 'class' => 'btn btn-sm btn-outline-info']
) ?>
<?= $this->Html->link(
	$this->Pretty->iconEdit($job->id) . 'Edit',
	['action' => 'edit', $job->id],
	['escape' => false, 'class' => 'btn btn-sm btn-outline-success']
) ?>
<?php endif; ?>
</div>
<?php
	$locHref = "https://www.google.com/maps/search/?api=1&query=";
	$locHref .= urlencode($job->location);
?>
<table class="table">
	<tr><th>Category</th><td><?= $job->category ?></td></tr>
	<tr><th>Description</th><td><?= $job->detail ?></td></tr>
	<tr><th>Start Date</th><td><?= $job->date_start->format("m/d/Y") ?></td></tr>
	<tr><th>End Date</th><td><?= $job->date_end->format("m/d/Y") ?></td></tr>
	<tr><th>Time(s)</th><td><?= $job->time_string ?></td></tr>
	<tr><th>Payroll Due Date</th><td><?= $job->due_payroll_submitted->format("m/d/Y") ?></td></tr>
	<tr><th>Paycheck Date</th><td><?= $job->due_payroll_paid->format("m/d/Y") ?></td></tr>
	<tr><th>Your Status</th><td><?= (empty($yourStat) ? "not specified" : ($yourStat->is_available ? "Interested, " : "Unavailable, ") . ($yourStat->is_scheduled ? "and Scheduled" : "and NOT scheduled")) ?></td></tr>
	<?php if ( $WhoAmI ) : ?>
		<?php 
			$totNeed = 0;
			$needed = [];
			foreach ( $job->roles as $role ) {
				$needed[] = $role->title . " <em>(" . $role->_joinData->number_needed . ")</em>";
				$totNeed += $role->_joinData->number_needed;
			}
		?>
		<tr><th>Staff Required - <?= $totNeed ?></th><td><?= join($needed, ", "); ?></td></tr>

		<?php
			$totAss = 0;
			$assed  = [];
			$assTot = [];
			$names  = [];
			foreach ( $job->users_sch as $user ) {
				$totAss += 1;
				if ( array_key_exists($user->id, $assTot) ) {
					$assTot[$user->id] += 1;
				} else {
					$assTot[$user->id] = 1;
					$names[$user->id] = $user->first . " " . $user->last;
				}
			}

			foreach ( $assTot as $key => $value ) {
				$assed[] = "<a class='text-info' href='/users/view/" . $key . "'>" . $names[$key] . (($value > 1 ) ? " <em>(".$value.")</em>":"") . "</a>";
			}
		?>
		<tr><th>Staff Assigned - <?= $totAss ?> </th><td><?= join($assed, ", "); ?></td></tr>

		<?php
			$totAss = 0;
			$assed  = [];
			$assTot = [];
			$names  = [];
			foreach ( $job->users_int as $user ) {
				$totAss += 1;
				if ( array_key_exists($user->id, $assTot) ) {
					$assTot[$user->id] += 1;
				} else {
					$assTot[$user->id] = 1;
					$names[$user->id] = $user->first . " " . $user->last;
				}
			}

			foreach ( $assTot as $key => $value ) {
				$assed[] = (( $WhoAmI ) ? "<a class='text-info' href='/users/view/" . $key . "'>" : "" ) . $names[$key] . (($value > 1 ) ? " <em>(".$value.")</em>":"") . (( $WhoAmI ) ? "</a>" : "" );
			}
		?>
		<tr><th>Staff Available - <?= $totAss ?> </th><td><?= join($assed, ", "); ?></td></tr>
	<?php endif; ?>
	<tr><th>Location</th><td><?= $job->location ?></td></tr>
</table>

<div class="mt-4 mb-2" style="border-bottom: 1px dashed #ccc;"><h4>Map</h4></div>
<div class="embed-responsive embed-responsive-4by3">
<div id="map-container" class="embed-responsive-item">
<div id="map">
<div><div><iframe width="600" height="500" id="map_canvas" src="https://maps.google.com/maps?q=<?=urlencode($job->location)?>&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no"></iframe></div></div>
</div>
</div> 
</div>`




		