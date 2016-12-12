<?php $this->layout('layout_eal_asupp', ['title' => 'Accueil']) ?>

<?php $this->start('main_content') ?>
	
	<div class="forms">

		<div class="page-header">
			<h1>Description du service</h1>
		</div>

		<form method="post" class="form-horizontal" enctype="multipart/form-data">

			<p class="text-required-filed">
				<span class="obligatoire">*</span>
				Champs obligatoires
			</p>

			<!-- Zone géographique concernée par le service -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="zip_code">
					Code postal du lieu du service
					<span class="obligatoire">*</span>
				</label>  
				<div class="col-md-2">
					<input id="zip_code" name="zip_code" type="text" class="form-control input-md" value="<?=isset($post['zip_code']) ? $post['zip_code'] : '';?>">
				</div>
				<!-- Gestion des erreurs -->
				<?php if(isset($formErrors['zip_code'])): ?>
					<div class="error col-md-offset-4 col-md-8"><?=$formErrors['zip_code']?></div>
				<?php endif; ?>
			</div>

			<!-- Objet de l'estimation -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="title">
					Objet du service
					<span class="obligatoire">*</span>
				</label>  
				<div class="col-md-4">
					<input id="title" name="title" type="text" class="form-control input-md" value="<?=isset($post['title']) ? $post['title'] : '';?>">
				</div>
				<!-- Gestion des erreurs -->
				<?php if(isset($formErrors['title'])): ?>
					<div class="error col-md-offset-4 col-md-8"><?=$formErrors['title']?></div>
				<?php endif; ?>
			</div>

			<!-- Description du projet -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="description">
					Descriptif du service
					<span class="obligatoire">*</span>
				</label>  
				<div class="col-md-6">
					<textarea id="description" name="description" rows="4" placeholder="Soyez le plus précis possible dans les éléments de description du service que vous souhaitez obtenir" class="form-control"><?=isset($post['title']) ? $post['title'] : '';?></textarea>
				</div>
				<!-- Gestion des erreurs -->
				<?php if(isset($formErrors['description'])): ?>
					<div class="error col-md-offset-4 col-md-8"><?=$formErrors['description']?></div>
				<?php endif; ?>
			</div>

			<!-- Date prévisionnelle du service -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="predicted_date">
					Date prévisonnelle (jj/mm/aaaa)
					<span class="obligatoire">*</span>
				</label>  
				<div class="col-md-2">
					<input id="predicted_date" name="predicted_date" type="text" class="form-control input-md" value="<?=isset($post['predicted_date']) ? $post['predicted_date'] : '';?>">
				</div>
				<!-- Gestion des erreurs -->
				<?php if(isset($formErrors['predicted_date'])): ?>
					<div class="error col-md-offset-4 col-md-8"><?=$formErrors['predicted_date']?></div>
				<?php endif; ?>
			</div>

			<!-- Catégorie du service -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="sector" >
					Catégorie
					<span class="obligatoire">*</span>
				</label>
				<div class="col-md-2">
					<select id="sector" name="sector" class="form-control">
						<option value="" selected disabled>Catégorie</option>
						<?php var_dump($sectors); ?>
						<?php foreach($sectors as $sector) :; ?>
							<option value="<?=$sector['id'];?>"><?=$sector['title'];?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-2">
					<select id="sub-sector" name="sub-sector" class="form-control">
						<option value="" selected disabled>Sous-Catégorie</option>
					</select>
				</div>
				<!-- Gestion des erreurs des catégories-->
				
			</div>	

			<!-- Si le User est déja connecté, ses infos de connexion ne lui sont pas demandées -->
			<?php if(!$w_user): ?>

				<!-- Email de l'utilisateur en cours de création du service -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="email">
						Email
						<span class="obligatoire">*</span>
					</label>  
					<div class="col-md-4">
						<input id="email" name="email" type="email" placeholder="votre@email.fr" class="form-control input-md">
					</div>
					<!-- Gestion des erreurs -->
					<?php if(isset($formErrors['email'])): ?>
						<div class="error col-md-offset-4 col-md-8"><?=$formErrors['email']?></div>
					<?php endif; ?>
				</div>

				<!-- Mot de passe de l'utilisateur en cours de création du service -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="password">
						Mot de passe
						<span class="obligatoire">*</span>
					</label>  
					<div class="col-md-4">
						<input id="email" name="password" type="password" class="form-control input-md">
					</div>
					<!-- Gestion des erreurs -->
					<?php if(isset($formErrors['password'])): ?>
						<div class="error col-md-offset-4 col-md-8"><?=$formErrors['password']?></div>
					<?php endif; ?>
				</div>

				<!-- Confirmation du mot de passe de l'utilisateur en cours de création du service -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="confirm-password">
						Confirmation du mot de passe
						<span class="obligatoire">*</span>
					</label>  
					<div class="col-md-4">
						<input id="email" name="confirm-password" type="confirm-password" class="form-control input-md">
					</div>
					<!-- Gestion des erreurs -->
					<?php if(isset($formErrors['confirm-password'])): ?>
						<div class="error col-md-offset-4 col-md-8"><?=$formErrors['confirm-password']?></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<!-- Bouton de validation -->
			<div class="form-group">
				<div class="col-md-3 col-md-offset-9">
					<button type="submit" class="btn btn-info btn-block">Valider</a>
				</div>
			</div>

		</form>
	</div>

<?php $this->stop('main_content') ?>

<?php $this->start('js') ?>
<script>
$(document).ready(function(){

	$('#sector').change(function(){
		alert('ca marche');
		$( "#sub-sector" ).load('<?=$this->url('ajax_refreshSubSector');?>');
	});
});

</script>
<script type="text/javascript">

	$(document).ready(function(){

		 $('button[type="submit"]').click(function(e){

			e.preventDefault(); //Empeche la soumission du formulaire
			
		
		});
	});


</script>
<?php $this->stop('js') ?>


