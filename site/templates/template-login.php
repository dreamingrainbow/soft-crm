<?php include('./_head-blank.php'); ?>

    <div class="container page">
        <div class="row">
            <div class="col-sm-6 col-md-offset-3">
               <div class="sign-in">
               		<p class="text-center"><img src="<?php echo $config->urls->files."images/dplus.png"; ?>" alt="Distribution Plus logo"></p>
               		<h2 class="text-center">Sign In</h2>
               		<?php if (!$user->loggedin) : ?>
						<?php $errormsg = get_loginerrormsg(session_id()); ?>
						<?php if (strlen($errormsg) > 0 ) : ?>
							<div class="alert alert-danger alert-dismissible not-round" role="alert">
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							  <strong>Warning!</strong> <?php echo $errormsg; ?>
							</div>
						<?php else : ?>
							<br>
						<?php endif; ?>
					<?php endif; ?>
               		<form action="<?php echo $config->pages->account."redir/"; ?>" method="post">
						<input type="hidden" name="action" value="login">
						<div class="input-group form-group">
							<span class="input-group-addon not-round"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" class="form-control not-round" name="username" value="" placeholder="username" autocapitalize="off" autofocus>
						</div>
						<div class="input-group form-group">
							<span class="input-group-addon not-round"><i class="glyphicon glyphicon-lock"></i></span>
							<input type="password" class="form-control not-round" name="password" placeholder="password">
						</div>
						<p class="text-center"> <button type="submit" class="btn btn-success not-round">Sign in</button> </p>

						<hr>
						<div class="form-group">
							<p></p>
						</div>
					</form>
               </div>
            </div>
        </div>
    </div>

<?php include('./_foot-blank.php'); // include footer markup ?>
