<div class="card rounded border shadow-sm mb-2">
<h4 class="text-center text-dark pt-2"><?= $date->format("F j, Y"); ?></h4>

<div class="btn-group w-100">
	<a href="<?= $dateView['prevLink'] ?>" class="btn btn-outline-light text-dark w-50 rounded-0"><?= $this->HtmlExt->icon("arrow-left-bold") ?> Previous Day</a>
	<a href="<?= $dateView['nextLink'] ?>" class="btn btn-outline-light text-dark w-50 rounded-0">Next Day <?= $this->HtmlExt->icon("arrow-right-bold") ?> </a>
</div>

<div class="p-3">
<?php if ( $jobs->count() < 1 ) : ?>
	<p class="text-center mb-0">No jobs scheduled for this day</p>
<?php endif; ?>


<?php foreach ( $jobs as $job ) : ?>

<?php 
	$isInt = false;
	$isSch = false;

	foreach ( $job->users_both as $stats ) {
		if ( $stats->_joinData->is_available ) { $isInt = true; }
		if ( $stats->_joinData->is_scheduled ) { $isSch = true; }
	}

?>
<a class="btn btn-outline-<?= ( $isSch ? "success" : ( $isInt ? "warning" : "dark" ) ) ?> w-100 mb-1" href="/jobs/view/<?= $job->id ?>"><?= $job->name ?></a>

<?php endforeach; ?>
</div>
</div>

<div class="card rounded border shadow-sm mb-2 p-3">
	<div class="w-100 p-1 mb-1 border border-success text-center text-success">You are scheduled for this event</div>
	<div class="w-100 p-1 mb-1 border border-warning text-center text-warning">You are available for this event</div>
</div>

<?= $this->Pretty->helpMeStart("Job Calendar - Daily"); ?>

<p>This display shows a calendar of all jobs.  Click on a job listing for additional detail. (Mobile will bring up a day view).</p>

<p>Please refer to the bottom of the page for details on the color code used.</p>

<?= $this->Pretty->helpMeEnd(); ?>