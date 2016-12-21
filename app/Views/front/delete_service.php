<?php $this->layout('layout', ['title' => 'Supprimer un service']); ?>

<?php $this->start('main_content') ?>
<div class="content-site">	
	<div class="forms">	
		<div class="page-header">
			<h1>Supprimer un service</h1>
		</div>
		
		<?php if(!empty($msg)): ?>
			<?php if($msg === 'success'): ?>
				<p class="alert alert-success">Service supprimé</p>
			<?php endif; ?>
			<?php if($msg === 'error'): ?>
				<p class="alert alert-danger">Ce service n'existe pas</p>
			<?php endif; ?>
			<div>
			<a href="<?=$this->url('front_list_services');?>" class="btn btn-info" title="Retour à la liste des services">Retour à la liste des services</a>
			</div>
		<?php endif; ?>

		<?php if(empty($msg)): ?>	

		<!-- Formulaire de delete -->

		<form method="post" class="form-horizontal">
			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<h3>Confirmez la suppression du service</h3>
					<a href="<?=$this->url('front_list_services');?>" class="btn btn-default" title="Retour à la liste des services">
					Annuler
					</a>
					&nbsp; 
					<button type="submit" class="btn btn-devirama" name="delete">
					Supprimer
					</button>
				</div>
			</div>
		</form>
		<?php endif; ?>
	</div>
</div>
<?php $this->stop('main_content') ?>