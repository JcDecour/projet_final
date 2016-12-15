<?php $this->layout('layout', ['title' => 'Liste des services']) ?>

<?php $this->start('main_content') ?>

	<div class="page-header">
			<h1>Liste des offres de services des particuliers</h1>
	</div>

	<!-- Formulaire de recherche -->
	<div class="well well-sm">
		<form method="get" class="form-inline">
			<!-- Code postal -->
			<div class="form-group">
				<label class="sr-only" for="zip_code">Code postal</label>
				<input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="CP" value="<?=isset($search['zip_code']) ? $search['zip_code'] : '';?>">
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
				
			<button class="btn btn-info" type="submit">
				<i class="fa fa-search"></i>
			</button>
				
			
		</form>
	</div>

	<!-- Liste des projets -->
	<?php if(!empty($projects)): ?>	

		<table class="table table-responsive table-bordered">

			<thead>
				<tr>
					<th>Lieu</th>
					<th>Service</th>
					<th>Créé le</th>
					<th>Prévu le</th>
					<th class="text-center">Offres</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($projects as $project): ?>
				<tr>
					<td><?=$project['zip_code'] ?></td>
					<td><?=$project['title'] ?></td>
					<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></td>
					<td><?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></td>
					<td class="text-center">
						<?php if($project['closed']): ?>
							<span class="text-danger">Cloturé</span>
						<?php else: ?>
							<span class="badge badge-success"><?=$project['nb_devis'];?></span>
						<?php endif; ?>	
					</td>
					<td class="text-center">
						<a href="<?=$this->url('front_service_view_allusers', ['id' => $project['id']]);?>" class="btn btn-success btn-sm" title="Consulter ce service">
					 		Consulter
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>

		</table>

	<?php else: ?>
		<p>Aucun service.</p>
	<?php endif; ?>

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