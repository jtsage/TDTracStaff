<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4"><?= $title ?></h3>

	<div class="btn-group-vertical">
		<?php foreach ( $lister as $item ) : ?>
			<?= $this->HtmlExt->iconBtnLink(
				"chevron-right-box", 
				( $action == "job" ) ? $item->category . " : " . $item->name : $item->comma_name,
				[ "action" => $action, $item->id ],
				[ 'class' => 'text-left btn btn-outline-primary w-100']
			); ?>
		<?php endforeach; ?>
	</div>
</div>


<?= $this->Pretty->helpMeStart("Choose User or Job"); ?>
<p>Choose the job of user to display.</p>
<?= $this->Pretty->helpMeEnd(); ?>

