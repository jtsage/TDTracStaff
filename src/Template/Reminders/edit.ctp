<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reminder $reminder
 */
?>
<div class="card p-3 rounded border shadow-sm mb-2">
<h3 class="text-dark mb-4">Edit A Reminder</h3>


	<?= $this->Form->create($reminder) ?>
	<fieldset>
		<?php 
			echo $this->Form->control('description');
			echo $this->Datebox->calbox('start_time', ["label" => 'Next Run Date', 'help' => 'Start Date of the reminder']);
			echo $this->Form->control('type', ["options" => [0 => "Cron Tracker", 1 => "Hours Due Reminder"]]);
            echo $this->Form->control('period', ["label" => "Run every # Days"]);
            
            $toUsers = json_decode($reminder->toUsers);
		?>
		<div style="border-bottom: 1px dashed #ccc;" class="mt-4 mb-2"><h5>Users to Notify</h5></div>
		<div class="row">
			<?php foreach ( $users as $user ) : ?>

				<div class="col-md-6">
				<?= $this->Form->input('user_' . $user->id , [
						'data-toggle'   => "toggle",
						'data-width'    => '100%',
						'data-height'   => '36px',
						'data-on'       => $user->last . ", " . $user->first,
						'data-off'      => $user->last . ", " . $user->first,
						'data-onstyle'  => 'success',
						'data-offstyle' => 'warning',
                        'type'          => 'checkbox',
                        'checked'       => in_array($user->id, $toUsers),
						'label'         => ""
					]); ?>
				</div>
			
			<?php endforeach; ?>
		</div>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("clock") . __('Save Reminder'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>
