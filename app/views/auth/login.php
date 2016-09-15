<div class="row">
    <div class="col-md-6 col-md-offset-3">

        
        <?php if ($error !== FALSE): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($error as $e): ?>
                        <li><?= $e ?></li>
                    <?php endforeach; ?>
                </ul>    

            </div>
        <?php endif; ?>


        <form method="POST">

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password">
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>

        </form>

    </div>
</div>