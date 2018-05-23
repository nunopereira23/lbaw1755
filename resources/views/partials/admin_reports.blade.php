<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
<div class="container">
    <h2>Reported Users</h2>
    <br>
    <table class="table table-condensed">
        <thead>
        <tr>
            <th><p>Name</p></th>
            <th><p>Email</p></th>
            <th><p>Report</p></th>
            <th><p>Actions</p></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($reports as $report) :?>
        <tr>
            <td><p><?php echo $report->getUserName() ?> </p></td>
            <td><p><?php echo $report->getUserEmail() ?></p></td>
            <td><p><?php echo $report->description ?></p></td>
            <td>
                <form method="post" action="/users/<?php echo $report->id_user ?>/warn">
                    {{ csrf_field() }}
                    <input type="submit" name="action" class="btn btn-warning" value="Warn"/>
                    <input type="hidden" name="id" value="<?php echo $report->id_user; ?>"/>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
