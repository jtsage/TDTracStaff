<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 */
?>
<h3>Add A Job</h3>
<div class="jobs form large-9 medium-8 columns content">
	<?= $this->Form->create($job) ?>
	<fieldset>
		<?php
			echo $this->Form->control('name', ["label" => "Name of Job"]);
			echo $this->Form->control('detail', ["label" => "Description of Job"]);
			echo $this->Form->control('category', ["label" => "Job Category", "help" => "Auto-completes with previously used categories for convenience."]);
			echo $this->Form->control('location', ["label" => "Job Location", "help" => "Presents as a Google Maps link, address preferred"]);
			
			echo $this->Pretty->calPicker('date_start', 'Start Date');
			echo $this->Pretty->calPicker('date_end', 'End Date');
			echo $this->Form->control('time_string', ["label" => "Job Time(s)", "help" => "Freeform times for the job. Limit to 250 characters."]);
		?>
	</fieldset>
	<?= $this->Form->button($this->Pretty->iconAdd("") . __('Add Job'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<script>

<?php
	$rows = [];
	foreach ( $allCats as $cat ) {
		$rows[] = [ "name" => $cat->category, "id" => null ];
	}
	echo "allCats = " . json_encode($rows) . ";\n";
?>

	var allCatsB = new Bloodhound({
		datumTokenizer: function (d) { return Bloodhound.tokenizers.whitespace(d.name); },
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		identify: function (obj) { return obj.name; },
		local: allCats
	});

	$('#category').typeahead({
		hint: true,
		highlight: true,
		minLength: 2
	},
	{
		name: 'active',
		display: 'id',
		source: allCatsB,
		templates: {
			header: '<h5 class="text-center">Saved Categories</h5>',
			suggestion: function (data) {
				return '<div>' + data.name + '</div>';
			}
		}
	}
	);

	$("#date_start-dbox").datebox( { 
		closeCallback : "linker",
		closeCallbackArgs :["date_end-dbox"]
	} );
</script>


