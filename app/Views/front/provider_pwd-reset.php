<?php $this->layout('layout', ['title' => 'Réinitialisation du mot de passe']); ?>

<?php $this->start('main_content') ?>
<div class="content-site width80">
	<div class="forms">					
		<div class="page-header text-center">
			<h1>Réinitialisation du mot de passe</h1>
		</div>

		<?php if(isset($formValid['valid'])): ?>
			<div class="alert alert-success text-center">
				<?=$formValid['valid'];?>
			</div>
		<?php endif; ?>
				
		<form method="post" class="form-horizontal" enctype="multipart/form-data">

				<!-- Mot de passe -->
					<div class="form-group">
						<!-- <label class="col-md-6 control-label" for="email">
							Nouveau mot de passe
						</label>   -->
						<div class="col-md-6 col-md-offset-3">
							<input id="password" name="password" type="password" placeholder="Nouveau mot de passe" class="form-control input-md">
						</div>
						<!-- Gestion des erreurs -->
						<?php if(isset($formErrors['password'])): ?>
							<div class="error col-md-6 col-md-offset-3"><?=$formErrors['password']?></div>
						<?php endif; ?>
					</div>

				<!-- confirmation de mot de passe -->
					<div class="form-group">
						<!-- <label class="col-md-6 control-label" for="email">
							Confirmez votre mot de passe
						</label> -->  
						<div class="col-md-6 col-md-offset-3">
							<input id="password_confirm" name="password_confirm" type="password" placeholder="Confirmez votre mot de passe" class="form-control input-md">
						</div>
						<!-- Gestion des erreurs -->
						<?php if(isset($formErrors['password_confirm'])): ?>
							<div class="error col-md-6 col-md-offset-3"><?=$formErrors['password_confirm']?>								
							</div>
						<?php endif; ?>
					</div>

				<!-- Submit -->

					<div class="form-group">

						<div class="col-md-6 col-md-offset-3">

							<button type="submit" class="btn btn-devirama btn-block">Réinitialiser</button>

						</div>
					</div>
		</form>
	</div>
</div>
	
<?php $this->stop('main_content') ?>
