<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="administration.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<body>
<div class="container">
    <h2>Banned Users</h2>
    <br>
    <table class="table table-condensed">
        <thead>
        <tr>
            <th><p>Name</p></th>
            <th><p>Email</p></th>
            <th><p>Description</p></th>
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
                    <input type="submit" name="action" value="Warn"/>
                    <input type="hidden" name="id" value="<?php echo $report->id_user; ?>"/>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
