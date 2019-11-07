<h4><?= $job->name ?></h4>

<table class="table">
	<tr><th>Category</th><td><?= $job->category ?></td></tr>
	<tr><th>Description</th><td><?= $job->detail ?></td></tr>
	<tr><th>Start Date</th><td><?= $job->date_start->format("m/d/Y") ?></td></tr>
	<tr><th>End Date</th><td><?= $job->date_end->format("m/d/Y") ?></td></tr>
	<tr><th>Time(s)</th><td><?= $job->time_string ?></td></tr>
	<tr><th>Payroll Due Date</th><td><?= $job->due_payroll_submitted->format("m/d/Y") ?></td></tr>
	<tr><th>Paycheck Date</th><td><?= $job->due_payroll_paid->format("m/d/Y") ?></td></tr>
	<tr><th>Location</th><td><?= $job->location ?></td></tr>
</table>

<h4 class="mt-5 mb-4">Scheduled Staff</h4>
<table class="table">
<?php foreach ( $job->roles as $role ) : ?>
	<tr>
		<th class="align-top w-25"><?= $role->title ?></th>
		<td>
			<table class="w-100">
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