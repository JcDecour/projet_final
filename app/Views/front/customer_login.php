<?php $this->layout('layout', ['title' => 'Connexion']); ?>

<?php $this->start('main_content') ?>

<div class="forms">

		<div class="page-header">
			<h1 class="text-center">Connexion</h1>
		</div>

		<?php if(isset($error) && !empty($error)): ?>
			<div class="alert alert-danger">
				<?=$error; ?>
			</div>
		<?php endif; ?>

		<form method="post" class="form-horizontal" enctype="multipart/form-data">
			
			<!-- Identifiant: Email -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="email">
						Email
					</label>  
					<div class="col-md-4">
						<input id="email" name="email" type="email" placeholder="votre@email.fr" class="form-control input-md">
					</div>
				</div>

				<!-- Mot de passe -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="password">
						Mot de passe
					</label>  
					<div class="col-md-4">
						<input id="email" name="password" type="password" class="form-control input-md">
					</div>
				</div>

				<!-- Submit -->

			<div class="form-group">
				<div class="col-md-4 col-md-offset-4">
					<button type="submit" class="btn btn-info btn-block">se connecter </button>
				</div>
			</div>

			<!-- Mot de passe oublié -->

			<div class="form-group">
				<div class="col-md-4 col-md-offset-4">
					<a href="#" class="text-danger">* Mot de passe oublié</a>
				</div>
			</div>


		</form>
</div>
	
<?php $this->stop('main_content') ?>
