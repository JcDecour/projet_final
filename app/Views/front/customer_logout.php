<?php $this->layout('layout', ['title' => 'Connexion']); ?>

<?php $this->start('main_content') ?>

<div class="content-site width80">

	<div class="forms">
		
		<div class="page-header text-center">
			<h1>Déconnexion</h1>
		</div>
		
		<!-- Formulaire de déconnexion -->
		<form method="post" class="form-horizontal">
				
			<div class="form-group">
				<div class="col-md-12 text-center">
					<h3>Confirmez-vous votre déconnexion ?</h3>

					<button class="btn btn-default" name="disconnect" value="no">
					Non
					</button>
					&nbsp; 
					<button class="btn btn-devirama" name="disconnect" value="yes">
					Oui
					</button>
				</div>
			</div>
		</form>

	</div>
	
</div>	

<?php $this->stop('main_content') ?>
