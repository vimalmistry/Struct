<nav class="navbar navbar-default">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<a class="navbar-brand" href="<?= url() ?>"><b>Follow Up</b></a>-->
        </div>


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?= url('#') ?>">Tasks <span class="sr-only">(current)</span></a></li>
                <!--<li><a href="#">Link</a></li>-->

            </ul>

            <ul class="nav navbar-nav navbar-right">

                <?php if (\Auth::check()): ?>
                    <li><a href="<?= url('auth/logout') ?>">Logout</a></li>
                <?php else: ?> 
                    <li><a href="<?= url('auth/login') ?>">Login</a></li>
                <?php endif; ?>


            </ul>
        </div>
    </div>
</nav>
