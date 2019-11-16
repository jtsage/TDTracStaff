<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Budget $budget
 */
?>
<div class="card p-3 rounded border shadow-sm mb-2">

	<h3 class="text-dark mb-4">Add Budget - <?= $job->category ?> - <?= $job->name ?></h3>

	<?= $this->Form->create($budget) ?>
	<fieldset>
		
		<?php
			echo $this->Form->control('category', ["autocomplete" => "new-user-address"]);
			echo $this->Form->control('vendor', ["autocomplete" => "new-user-address"]);
			
			echo $this->Form->control('detail', ["label" => "Description"]);
			echo $this->Datebox->calbox('date');
			echo $this->Form->control('amount', ["prepend" => "$"]);
			
		?>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("credit-card-plus") . __('Add Budget Item'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<script>

<?php
	$rows = [];
	foreach ( $allCats as $cat ) {
		$rows[] = [ "name" => $cat->category, "id" => $cat->category ];
	}
	echo "allCats = " . json_encode($rows) . ";\n";
	$rows = [];
	foreach ( $allVendor as $cat ) {
		$rows[] = [ "name" => $cat->vendor, "id" => $cat->vendor ];
	}
	echo "allVendor = " . json_encode($rows) . ";\n";
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

	var allVendorB = new Bloodhound({
		datumTokenizer: function (d) { return Bloodhound.tokenizers.whitespace(d.name); },
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		identify: function (obj) { return obj.name; },
		local: allVendor
	});

	$('#vendor').typeahead({
		hint: true,
		highlight: true,
		minLength: 2
	},
	{
		name: 'active',
		display: 'id',
		source: allVendorB,
		templates: {
			header: '<h5 class="text-center">Saved Vendors</h5>',
			suggestion: function (data) {
				return '<div>' + data.name + '</div>';
			}
		}
	}
	);
</script>
