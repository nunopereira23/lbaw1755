<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
<div class="container">
    <h2>Active Users</h2>
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
        <?php foreach ($activeUsers as $user) :?>
        <tr>
            <td><p><?php echo $user->name ?> </p></td>
            <td><p><?php echo $user->email ?></p></td>
            <td>
                <form method="post" action="/users/<?php echo $user->id ?>/ban">
                    {{ csrf_field() }}
                    <input type="submit" name="action" class="btn btn-danger" value="Ban"/>
                    <input type="hidden" name="id" value="<?php echo $user->id; ?>"/>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>


