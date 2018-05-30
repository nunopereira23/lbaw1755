<!DOCTYPE html>
<head>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <title> "Banned users" </title>
</head>
<body>
<div class="container" id="admin">
    <h2>Banned Users</h2>
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
        <?php foreach ($bannedUsers as $user) :?>
        <tr>
            <td><p><?php echo $user->name ?> </p></td>
            <td><p><?php echo $user->email ?></p></td>
            <td>
                <form method="post" action="/users/<?php echo $user->id ?>/reinstate">
                    {{ csrf_field() }}
                    <input type="submit" name="action" class="btn btn-success" value="Reinstate"/>
                    <input type="hidden" name="id" value="<?php echo $user->id; ?>"/>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
</body>
</html>

