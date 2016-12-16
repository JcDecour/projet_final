<?php $this->layout('layout', ['title' => 'Ajout d\'un service']) ?>

<?php $this->start('main_content') ?>
<div class="content-site">	
	<div class="forms">

		<div class="page-header">
			<h1>Description du service à ajouter</h1>
		</div>

		<form method="post" class="form-horizontal" enctype="multipart/form-data">

			<p class="text-required-filed">
				<span class="obligatoire">*</span>
				Champs obligatoires
			</p>

			<?php if(isset($formErrors['global'])): ?>
				<div class="alert alert-danger">
					<?=$formErrors['global'];?>
				</div>
			<?php endif; ?>

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
					<textarea id="description" name="description" rows="4" placeholder="Soyez le plus précis possible dans les éléments de description du service que vous souhaitez obtenir" class="form-control"><?=isset($post['description']) ? $post['description'] : '';?></textarea>
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
					Catégorie / Sous Catégorie
					<span class="obligatoire">*</span>
				</label>
				<div class="col-md-2">
					<select id="sector" name="sector" class="form-control">
						<option value="" selected disabled>Catégorie</option>
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
				<button class="add_ss_categ_button btn btn-success">Ajouter</button>
				<!-- Gestion des erreurs -->
				<?php if(isset($formErrors['tabSsCateg'])): ?>
					<div class="error col-md-offset-4 col-md-8"><?=$formErrors['tabSsCateg']?></div>
				<?php endif; ?>
				
			</div>	

			<!-- Sous catégories sélectionnées -->
			<div class="form-group">
				<div class="input_categ_wrap col-md-offset-4 col-md-8">
					<?php if(!empty($contenuSsSector)): ?>
						<?=$contenuSsSector;?>
					<?php endif; ?>
				</div>
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
						<input id="email" name="email" type="text" placeholder="votre@email.fr" class="form-control input-md" value="<?=isset($post['email']) ? $post['email'] : '';?>">
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
						<input id="s" name="password" type="password" class="form-control input-md" value="<?=isset($post['password']) ? $post['password'] : '';?>">
					</div>
					<!-- Gestion des erreurs -->
					<?php if(isset($formErrors['password'])): ?>
						<div class="error col-md-offset-4 col-md-8"><?=$formErrors['password']?></div>
					<?php endif; ?>
				</div>

			<?php endif; ?>

			<!-- Bouton de validation -->
			<div class="form-group">
				<div class="col-md-3 col-md-offset-9">
					<button type="submit" class="btn btn-info btn-block">Valider</button>
				</div>
			</div>

		</form>
	</div>
</div>
<?php $this->stop('main_content') ?>

<?php $this->start('js') ?>
<script>
	$(document).ready(function(){

		/*Gestion des menu déroulants liés (Carégories -> Sous Catégories)*/
		$('#sector').change(function(){
			$.ajax({
				url: '<?=$this->url('ajax_refreshSubSector'); ?>',
				type: 'get',
				cache: false,
				data: {idsector: $('#sector').find(":selected").attr('value') }, 
				dataType: 'json', 
				success: function(result) {
					console.log(result);
					$('#sub-sector').html(result.option);
				}
			});
		});

		/*Gestion de l'ajout d'une sous-catégorie*/
		$('.add_ss_categ_button').click(function(e){
	        e.preventDefault();

	        //Récupération du libelle de la catégorie
			var title_categ = $( "#sector option:selected" ).text();
	        var title_ss_categ = $( "#sub-sector option:selected" ).text();
	        var id_ss_categ = $('#sub-sector').find(":selected").attr('value');

	        if(id_ss_categ){
		        var contenu = '<div>'+title_categ+' - '+title_ss_categ+'<input type="hidden" value="'+id_ss_categ+'" name="tabSsCateg[]"/><a href="#" class="remove_ss_categ_button"> Supprimer</a></div>';

		        $('.input_categ_wrap').append(contenu);
		    }
	    });

		/*Gestion de la suppression d'une sous catégorie*/
		$('.input_categ_wrap').on("click",".remove_ss_categ_button", function(e){ 
	        e.preventDefault(); 
	        $(this).parent('div').remove(); 
	    })

	});
</script>
<?php $this->stop('js') ?>


