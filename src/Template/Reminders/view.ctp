<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reminder $reminder
 */
?>
<div class="card p-3 rounded border shadow-sm mb-2">
<h3 class="text-dark mb-4">Reminder - <?= h($reminder->description) ?></h3>



    <table class="vertical-table table w-100">
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= ["", "Remind to Submit Hours"][$reminder->type] ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Period (Number of days between)') ?></th>
            <td><?= $this->Number->format($reminder->period) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Time') ?></th>
            <td><?= h($reminder->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Run') ?></th>
            <td><?= h($reminder->last_run) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($reminder->created_at) ?></td>
        </tr>
    </table>
    
        <h4><?= __('Users To Notify') ?></h4>
        <ul>
            <?php 
                $usersTo = json_decode($reminder->toUsers);
                foreach ( $usersTo as $thisUser ) :
            ?>
                <li><?= $users[$thisUser] ?></li>
            <?php endforeach; ?>
        </ul>
    

<?= $this->Html->link(__('Edit'), ['action' => 'edit', $reminder->id], ['class' => 'btn btn-success w-100']) ?>

</div>
