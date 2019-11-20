<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppConfig $appConfig
 */
?>
<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark">Application Setting: <?= h($appConfig->key_name) ?></h3>

	<p class="text-dark"><?= $appConfig->value_short ?></p>

	<?= $this->HtmlExt->iconBtnlink(
		"playlist-edit" , "Edit this Config",
		['action' => 'edit', $appConfig->id],
		['class' => 'btn btn-outline-success btn-lg mb-3 w-100']
	) ?>
</div>

<div class="card p-3 rounded border shadow-sm mb-2">
	<h5 style="border-bottom: 1px dashed #ccc" class="text-dark">Current Value</h5>
	<?= nl2br(preg_replace("/\\\\n/", "\n", $appConfig->value_long)); ?>
</div>


<?= $this->Pretty->helpMeStart("Topic Unavailable"); ?>
<p>View help at the Application Configuration list screen instead.</p>
<?= $this->Pretty->helpMeEnd(); ?>
