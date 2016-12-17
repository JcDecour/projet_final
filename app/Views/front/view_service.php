<?php $this->layout('layout', ['title' => 'Liste des devis pour le service']); ?>

<?php $this->start('my_header') ?>

<?php $this->stop('my_header') ?>

<?php $this->start('main_content') ?>

<div class="content-site">
	<div class="row">
		<div class="page-header">
			<h1>Liste des devis pour le service</h1>
		</div>
	</div>
	<div class="row">
		<ul class="list-group col-md-4">
		  <li class="list-group-item">Service&nbsp;:&nbsp;<?=$project['title'] ?></li>
		  <li class="list-group-item">Crée le&nbsp;:&nbsp;<?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?></li>
		  <li class="list-group-item">Délai&nbsp;:&nbsp;<?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></li>
		</ul>
	</div>


<?php $cpt = 0;?>

<form method="POST">

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
		    	<th class="text-center">Prix TTC (€)</th>
		    </thead>
		 
			<tbody>

			  	<?php foreach($datasDevis as $dataDevis): ?>

				  	

				  		<?php if($projectSubSector['id'] == $dataDevis['projectSubsectorId']):?>

						  	<tr>
						  		<td>
						  			<input id="<?= $dataDevis['devisId'] ?>" type="checkbox" name="choice" value="<?= $dataDevis['ttc_amount'] ?>">
						  		</td>
						  		<td><?=$dataDevis['devisId'] ?></td>
						  		<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $dataDevis['devisDateCreat'])->format('d/m/Y');?></td>
						  		<td><?=$dataDevis['companyName'] ?></td>
						  		<td><?=number_format($dataDevis['ttc_amount'], 2, ',', ' ') ?></td>
						  		<td><?=$dataDevis['tva_amount'] ?></td>
						  		<td class="text-right"><?=number_format($dataDevis['ttc_amount'], 2, ',', ' ') ?></td>
						  	</tr>

							<?php $cpt++;?>

				 		<?php endif; ?>

				  	
			  	 
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
		<div class="col-md-8"></div>
		<div class="col-md-2 ">
			<strong>Total TTC :</strong>
		</div>
		<div class="col-md-2 text-right "><span id="totalResult">0.00</span></div>
	</div>
	
	<div class="row">
		<div class="col-md-4 col-md-offset-8">
			<button type="submit" class="btn btn-primary btn-block">Accepter</button>
		</div>
	</div>
	<div id="inputHidden"></div>
</form>




</div>

<?php $this->stop('main_content') ?>

<?php $this->start('js') ?>

<script type="text/javascript">

$(document).ready(function() {

		$('input[type=checkbox]').click(function(){

			var total= 0;

			$('#inputHidden').empty();

			$('input[type=checkbox]:checked').each(function() {

				total += parseFloat($(this).val());

				var idCheckbox = $(this).attr("id");



				$('#inputHidden').append('<input type="hidden" name="acceptedDevis'+idCheckbox+'" value='+idCheckbox+'>');


			});
	
		 	$('#totalResult').html(new Intl.NumberFormat("fr-FR",   {style: "currency", currency: "EUR"}).format(total));

		});



});

</script>

<?php $this->stop('js') ?>
