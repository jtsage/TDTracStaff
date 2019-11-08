
<h3>Calendar View</h3>

<div class="btn-group w-100">
	<a href="<?= $dateView['prevLink'] ?>" class="btn btn-outline-dark w-50"><?= $this->Pretty->iconPrev("") ?> Previous Month</a>
	<a href="<?= $dateView['nextLink'] ?>" class="btn btn-outline-dark w-50">Next Month <?= $this->Pretty->iconNext("") ?> </a>
</div>

<table class="table table-bordered my-2 w-100">
<tr>
	<td class="text-center p-1 p-md-3 m-0" colspan="7"><strong><em><?= $calViewInfo->format("F Y") ?></em></strong></td>
</tr>
<tr>
	<th class="text-center p-1 p-md-2 m-0">S<span class="d-none d-md-inline">unday</span></th>
	<th class="text-center p-1 p-md-2 m-0">M<span class="d-none d-md-inline">onday</span></th>
	<th class="text-center p-1 p-md-2 m-0">T<span class="d-none d-md-inline">ueday</span></th>
	<th class="text-center p-1 p-md-2 m-0">W<span class="d-none d-md-inline">ednesday</span></th>
	<th class="text-center p-1 p-md-2 m-0">T<span class="d-none d-md-inline">hursday</span></th>
	<th class="text-center p-1 p-md-2 m-0">F<span class="d-none d-md-inline">riday</span></th>
	<th class="text-center p-1 p-md-2 m-0">S<span class="d-none d-md-inline">aturday</span></th>
</tr>
<?php for ( $row = 0; $row < count($calData); $row++ ) : ?>
	<tr>
		<?php for ( $col = 0; $col < 7; $col++ ): ?>
			<td style="width: 14.2%" class="p-1 m-0 col">
				<div class="d-md-none w-100 text-center p-1 rounded-circle <?= ( $calData[$row][$col]['ovrStatus'] == 2 ? "bg-success text-white" : ($calData[$row][$col]['ovrStatus'] == 1 ? "bg-warning text-white" : "text-dark" ) ) ?>">
					<a class="<?= ($calData[$row][$col]['thisMonth']) ? "text-reset" : "text-muted" ?>" href="/jobs/day/<?= $calData[$row][$col]['date'] ?>"><?= $calData[$row][$col]['day'] ?></a>
				</div>
				<div class="p-0 d-none d-md-block">
					<div class="w-100 pt-2 pr-2 mb-3 text-right <?= ($calData[$row][$col]['thisMonth']) ? "text-dark" : "text-muted" ?>"><?= $calData[$row][$col]['day'] ?></div>
					<?php $thisSize = $maxSize; ?>
					<?php foreach ( $calData[$row][$col]['events'] as $event ): ?>
						<div class="w-100 rounded-pill mb-1 px-2 <?= ( $event['status'] == 2 ? "bg-success" : ($event['status'] == 1 ? "bg-warning" : "" ) ) ?>">
							<a class="text-white" href="/jobs/view/<?= $event["id"] ?>"><?= $event["name"] ?></a>
						</div>
						<?php $thisSize--; ?>
					<?php endforeach; ?>
					<?php for ( ; $thisSize > 0; $thisSize--) : ?>
						<div class="w-100 mb-1 px-1">&nbsp;</div>
					<?php endfor; ?>
				</div>
			</td>
		<?php endfor; ?>
	</tr>
<?php endfor; ?>
</table>

<div>
	<div class="w-100 rounded-pill p-1 mb-1 bg-success text-center text-white">You are scheduled <span class="d-md-none">on this day</span><span class="d-none d-md-inline">for this event</span></div>
	<div class="w-100 rounded-pill p-1 mb-1 bg-warning text-center text-white">You are available <span class="d-md-none">on this day</span><span class="d-none d-md-inline">for this event</span></div>
</div>
