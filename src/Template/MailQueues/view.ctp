
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= h($mailQueue->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Template') ?></th>
                <td><?= h($mailQueue->template) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('ToUser') ?></th>
                <td><?= h($mailQueue->toUser) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Subject') ?></th>
                <td><?= h($mailQueue->subject) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created At') ?></th>
                <td><?= h($mailQueue->created_at) ?></td>
            </tr>
        </table>
    </div>
    
    
    <div class="px-3 pb-3 pt-1"><?= $mailQueue->body; ?></div>
    
</div>
