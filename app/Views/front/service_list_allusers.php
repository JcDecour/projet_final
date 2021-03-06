<?php $this->layout('layout', ['title' => 'Liste des services']) ?>

<?php $this->start('main_content') ?>


<div class="content-site">
	
	<div class="page-header">
		<h1>Liste des offres de services</h1>
	</div>
    
	<div class="accrocheNbOffre">
		<span class="accroche">
			<i class="fa fa-fw fa-quote-left"></i>
			<?php if($projectsTotal['nbTotalService'] == 0): ?>
				Il n'y a pas d'offre de service à pourvoir
			<?php elseif($projectsTotal['nbTotalService'] == 1): ?>
				1 offre de service est à pourvoir
			<?php else: ?>	
				Actuellement, <?=$projectsTotal['nbTotalService'];?> offres de services sont à pourvoir
			<?php endif; ?>
			<i class="fa fa-fw fa-quote-right"></i>
		<span>
	</div>


	<!-- Formulaire de recherche -->
	<div class="well well-sm">
		<form method="get" class="form-inline">
			<!-- Code postal -->
			<div class="form-group">
				<label class="sr-only" for="zip_code">Code postal</label>
				<input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="CP" value="<?=isset($search['zip_code']) ? $search['zip_code'] : '';?>">
			</div>

			<!-- Service (Recherche dans le sujet ou la description) -->
			<div class="form-group">
				<label class="sr-only" for="title">Un type de contenu de service</label>
				<input type="text" class="form-control" id="title" name="title" placeholder="Libellé service" value="<?=isset($search['title']) ? $search['title'] : '';?>">
			</div>

			<!-- Catégorie -->
			<select id="sector" name="sector" class="form-control">
				<option value="" selected>Catégorie</option>
				<?php foreach($sectors as $sector) :; ?>
					<option value="<?=$sector['id'];?>" <?=(isset($search['sector']) && $search['sector'] == $sector['id']) ? 'selected' : '';?>><?=$sector['title'];?></option>
				<?php endforeach; ?>
			</select>

			<!-- Sous-Catégorie -->
			<select id="sub-sector" name="sub-sector" class="form-control">
				<?php if(!empty($optionSubSector)):?>
					<?=$optionSubSector;?>
				<?php else: ?>
					<option value="" selected>Sous-Catégorie</option>
				<?php endif; ?>
			</select>
				
			<button class="btn btn-devirama" type="submit">
				Rechercher
			</button>
				
			
		</form>
	</div>

	<!-- Liste des projets -->
	<?php if(!empty($projects)): ?>	

		<table class="table table-responsive table-bordered table-striped">

			<thead>
				<tr>
					<th>
                        N° Offre
                        &nbsp;
                        <i class="fa fa-fw fa-sort-amount-desc"></i>
                    </th>
					<th>Lieu</th>
					<th>Service</th>
					<th>Ajoutée le</th>
					<th>Prévue le</th>
					<th class="text-center">Devis</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($projects as $project): ?>
				<tr>
					<td><?=sprintf("%06d", $project['id'])?></td>
					<td><?=$project['zip_code'] ?></td>
					<td><?=$project['title'] ?></td>
					<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></td>
					<td><?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></td>
					<td class="text-center-basic-table">
						<?php if($project['closed']): ?>
							<span class="text-danger">Cloturé</span>
						<?php else: ?>
							<span class="badge badge-success"><?=$project['nb_devis'];?></span>
						<?php endif; ?>	
					</td>
					<td class="text-center-basic-table">
						<a href="<?=$this->url('front_service_view_allusers', ['id' => $project['id']]);?>" class="btn btn-default btn-sm" title="Consulter ce service">
					 		Consulter
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>

		</table>

	<?php else: ?>
        <?php if($projectsTotal['nbTotalService'] > 0): ?>
		  <p>Aucune offre de services ne répond à vos critères de recherche.</p>
        <?php endif; ?>
	<?php endif; ?>

   
     
<div >

    
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

	});
</script>
<?php $this->stop('js') ?>