<?php $this->layout('layout', ['title' => 'Liste des devis pour le service']); ?>

<?php $this->start('my_header') ?>

<?php $this->stop('my_header') ?>

<?php $this->start('main_content') ?>

	<div class="page-header">
		<h1>Liste des devis pour le service</h1>
	</div>

	<div class="row">
		<ul class="list-group col-md-4">
		  <li class="list-group-item">Service&nbsp;:&nbsp;<?=$project['title'] ?></li>
		  <li class="list-group-item">Crée le&nbsp;:&nbsp;<?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></li>
		  <li class="list-group-item">Délai&nbsp;:&nbsp;<?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></li>
		</ul>
	</div>
<!-- on utilise un compteur pour gérer l'absence de devis pour un service -->
	<?php $cpt = 0;?>

	<?php foreach($projectsSubSector as $projectSubSector): ?>
	<div class="row">
		<div class="panel panel-primary">
		 
		  <div class="panel-heading"><?=$projectSubSector['title'] ?></div>

		  
		  <table class="table table-responsive table-bordered">
		    <thead>
		    	<th>Votre choix</th>
		    	<th>Devis</th>
		    	<th>Date de création</th>
		    	<th>Société</th>
		    	<th>Prix HT</th>
		    	<th>TVA %</th>
		    	<th>Prix TTC (€)</th>
		    </thead>
		 
			<tbody>

			  	<?php foreach($datasDevis as $dataDevis): ?>

				  	<?php foreach($dataDevis as $data): ?>

				  		<?php if($projectSubSector['id'] == $data['id_project_subsector']):?>

						  	<tr>
						  		<td>
						  			<input type="checkbox" name="choice" value="<?=$data['ttc_amount'] ?>">
						  		</td>
						  		<td><?=$data['id'] ?></td>
						  		<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $data['created_at'])->format('d/m/Y');?></td>
						  		<td><?=$data['company_name'] ?></td>
						  		<td><?=$data['ht_amount'] ?></td>
						  		<td><?=$data['tva_amount'] ?></td>
						  		<td class="text-right"><?=$data['ttc_amount'] ?></td>
						  	</tr>

							<?php $cpt++;?>

				 		<?php endif; ?>

				  	<?php endforeach; ?>
			  	 
			  	<?php endforeach; ?>
			 
			 </tbody>

			<?php if($cpt == 0):?>
				<tbody>
					<tr>
						<td colspan="7" class="text-danger">Aucun devis enregistré</td>
					</tr>
				</tbody>
			<?php endif;?>

			<?php $cpt=0;?>

		   </table>
		</div>
	</div>
	<?php endforeach; ?>

	<div class="row" >
		<div class="col-md-9"></div>
		<div class="col-md-2 ">
			<strong>Total TTC :</strong>
		</div>
		<div class="col-md-1 text-right "><span id="totalResult">0.00</span></div>
	</div>
	
	<div class="row">
		<div class="col-md-3 col-md-offset-9">
			<button type="submit" class="btn btn-primary btn-block">Accepter</button>
		</div>
	</div>

<?php $this->stop('main_content') ?>

<?php $this->start('js') ?>

<script type="text/javascript">

$(document).ready(function() {

		$('input[type=checkbox]').click(function(){

			var total= 0;

			$('input[type=checkbox]:checked').each(function() {

				total += parseFloat($(this).val());

			});
	
		 	$('#totalResult').html( total );

		});

});

</script>

<?php $this->stop('js') ?>
