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
    <h1>Admin</h1>
    <h2>Registered Users</h2>
    <br>
    <table class="table table-condensed">
        <thead>
        <tr>
            <th><p>Name</p></th>
            <th><p>Email</p></th>
            <th><p>Actions</p></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) :?>
        <tr>
            <td><p><?php echo $user->name ?> </p></td>
            <td><p><?php echo $user->email ?></p></td>
            <td>
                <button type="button" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit"></span></button>
                <button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></button>
            </td>
        </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>

<footer class="copyright">
    <div class="footer-copyright py-3 text-center">
        <div class="container">
            <hr>
© 2018 I am In!
        </div>
    </div>
</footer>

