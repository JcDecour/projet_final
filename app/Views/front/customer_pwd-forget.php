<?php $this->layout('layout', ['title' => 'Mot de passe perdu']); ?>

<?php $this->start('main_content') ?>
<div class="content-site width50">
	<div class="forms">					
		<div class="page-header text-center">
			<h1>Mot de passe perdu</h1>
		</div>

		<?php if(isset($formValid['valid'])): ?>
			<div class="alert alert-success text-center">
				<?=$formValid['valid'];?>
			</div>
		<?php endif; ?>
				
		<form method="post" class="form-horizontal" enctype="multipart/form-data">

				<!-- Identifiant: Email -->
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							<input id="email" name="email" type="email" placeholder="Votre@email.fr" class="form-control input-md">
						</div>
						<!-- Gestion des erreurs -->
						<?php if(isset($formErrors['email'])): ?>
							<div class="error col-md-offset-3 col-md-6"><?=$formErrors['email']?></div>
						<?php endif; ?>
					</div>

					<!-- Submit -->

				<div class="form-group">
					<div class="col-md-6 col-md-offset-3">
						<button type="submit" class="btn btn-info btn-block">Valider</button>
					</div>
				</div>

		</form>
	</div>
</div>
	
<?php $this->stop('main_content') ?>
