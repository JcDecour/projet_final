<?php $this->layout('layout', ['title' => 'Connexion Particulier']); ?>

<?php $this->start('main_content') ?>

<div class="content-site width50">

	<div class="forms">	

		<div class="page-header text-center">
			<h1>Connexion Particulier</h1>
		</div>
		
		<br>

		<?php if(isset($_SESSION['formValid'])): ?>
			<div class="alert alert-info" class="text-center" role="alert">
				<?=$_SESSION['formValid'];?>
				<?php unset($_SESSION['formValid']);?>
			</div>
		<?php endif; ?>
				
		<form method="post" class="form-horizontal" enctype="multipart/form-data">
				
				<!-- Message de confirmation si inscription ok -->

				<?php if(isset($_SESSION['formValid'])): ?>
					<div class="alert alert-info" style="text-align: center;" role="alert">
						<?=$_SESSION['formValid'];?>
					</div>
				<?php endif; ?>

				<!-- Gestion des erreurs -->
				<?php if(isset($error) && !empty($error)): ?>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3 text-danger">
							<?=$error; ?>
						</div>
					</div>
				<?php endif; ?>

				<!-- Identifiant: Email -->
				<div class="form-group">
					<div class="col-md-6 col-md-offset-3">
						<input id="email" name="email" type="email" placeholder="Votre@email.fr" class="form-control input-md">
					</div>
				</div>

				<!-- Mot de passe -->
				<div class="form-group">
					<div class="col-md-6 col-md-offset-3">
						<input id="email" name="password" type="password" placeholder="Votre mot de passe" class="form-control input-md">
					</div>
				</div>

				<!-- Submit -->
				<div class="form-group">
					<div class="col-md-6 col-md-offset-3">
						<button type="submit" class="btn btn-info btn-block">Se connecter </button>
					</div>
				</div>

				<!-- Mot de passe oublié -->
				<div class="form-group">
					<div class="col-md-4 col-md-offset-4">
						<a href="#" class="text-danger">Mot de passe oublié</a>
					</div>
				</div>

		</form>

	</div>

</div>
	
<?php $this->stop('main_content') ?>
