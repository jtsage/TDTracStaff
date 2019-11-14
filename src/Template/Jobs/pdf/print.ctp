<h2><?= $job->name ?></h2>

<table class="list" cellpadding="0" cellspacing="0">
	<tr><th>Category</th><td><?= $job->category ?></td></tr>
	<tr><th>Description</th><td><?= $job->detail ?></td></tr>
	<tr><th>Start Date</th><td><?= $job->date_start->format("m/d/Y") ?></td></tr>
	<tr><th>End Date</th><td><?= $job->date_end->format("m/d/Y") ?></td></tr>
	<tr><th>Time(s)</th><td><?= $job->time_string ?></td></tr>
	<tr><th>Payroll Due Date</th><td><?= $job->due_payroll_submitted->format("m/d/Y") ?></td></tr>
	<tr><th>Paycheck Date</th><td><?= $job->due_payroll_paid->format("m/d/Y") ?></td></tr>
	<tr><th>Location</th><td><?= $job->location ?></td></tr>
</table>

<h3>Scheduled Staff</h3>
<table style="width:100%" cellpadding="0" cellspacing="0">
<?php foreach ( $job->roles as $role ) : ?>
	<tr>
		<th style="padding: 3px; border: 1px solid #333; margin:0; background-color: rgb(234,245,255); vertical-align:top; width:25%"><?= $role->title ?></th>
		<td style="padding: 3px; border: 1px solid #333; margin:0;">
			<table style="width: 100%">
			<?php foreach ( $interest as $person ): ?>
				<?php if ( $person->role_id == $role->id ) : ?>
					<tr>
						<td class="border-0 m-0 p-0" style="width:33%"><?= $person->user->first ?> <?= $person->user->last ?></td>
						<td class="border-0 m-0 p-0" style="width:33%"><?= $person->user->phone ?></td>
						<td class="border-0 m-0 p-0" ><?= $person->user->username ?></td>
					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
			</table>
		</td>
	</tr>
<?php endforeach; ?>
</table>
