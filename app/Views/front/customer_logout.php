<?php $this->layout('layout', ['title' => 'Connexion']); ?>

<?php $this->start('main_content') ?>
<div class="content-site">

	<div class="forms">
		
		<div class="page-header">
			<h1>Déconnexion</h1>
		</div>
		
		<!-- Formulaire de déconnexion -->
		<form method="post" class="form-horizontal">
				
			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<h3>Confirmez votre déconnexion</h3>

					<button class="btn btn-default" name="disconnect" value="no">
					Non
					</button>
					&nbsp; 
					<button class="btn btn-info" name="disconnect" value="yes">
					Oui
					</button>
				</div>
			</div>
		</form>
	</div>
</div>	
<?php $this->stop('main_content') ?>
