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
	
	 <!--Partie entete du service (Récapitulatif)-->
        <!-- N° de l'offre -->
	<div class="row">
		<label class="col-md-3 control-label text-right">N° Offre:</label>  
		<div class="col-md-9"><?=sprintf("%06d", $project['id'])?>&nbsp;( Ajoutée le <?=DateTime::createFromFormat('Y-m-d H:i:s', $project['created_at'])->format('d/m/Y');?> )</div>
	</div>
    
        <!-- Code postal du lieu du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right">Code postal du lieu du service:</label>  
		<div class="col-md-9"><?=$project['zip_code'];?></div>
	</div>

	   <!-- Objet du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right">Objet du service:</label>  
		<div class="col-md-9"><?=$project['title'];?></div>
	</div>

	<br>

	   <!-- Description du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right">Description:</label>  
		<div class="col-md-7 withbackground"><?=nl2br($project['description']);?></div>
	</div>
    
    <br>

     <!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right">Date prévisionnelle:</label>  
		<div class="col-md-9">
			<?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?>		
		</div>
	</div>

	<br>
    
<?php $cpt = 0;?>

<?php if(!$project['closed']): ?>
<form method="POST">

	<?php foreach($sectors as $sector): ?>

	<!-- Partie devis-->
	<div class="row">
	    <div class="panel panel-default">
			  <!-- Default panel contents -->
				<div class="panel-heading">
				  	
				  		<?=$sector['sectorTitle'];?> - <?=$sector['subSectorTitle'];?>		  		
				  	
				</div>

				<div class="panel-body">
			  
				  	<table class="table table-bordered table-responsive ">
					    <thead>
					    	<th class="text-center">Choix</th>
					    	<th>N° Devis</th>
					    	<th>Créé le</th>
					    	<th>Société</th>
					    	<th class="text-right">Montant HT(€)</th>
					    	<th class="text-right">Taux de TVA(%)</th>
					    	<th class="text-right">Montant TTC (€)</th>
					    </thead>
					 
						<tbody>

						<?php $cpt2 = 0; ?>
						  	<?php foreach($datasDevis as $dataDevis): ?>
							
						  		<?php if($sector['projectSubSectorId'] == $dataDevis['projectSubsectorId']):?>

								  	<tr <?php if($cpt2%2){echo 'class=""';}else{echo 'class="devis-striped"';};?>>
								  		<td class="text-center">
								  			<input id="<?= $dataDevis['devisId'] ?>" type="checkbox" name="" value="<?= $dataDevis['ttc_amount'] ?>">
								  		</td>
								  		<td><?=sprintf("%06d", $dataDevis['devisId'])?></td>
								  		<td><?=DateTime::createFromFormat('Y-m-d H:i:s', $dataDevis['devisDateCreat'])->format('d/m/Y');?></td>
								  		<td><?=$dataDevis['companyName'] ?></td>
								  		<td class="text-right"><?=number_format($dataDevis['ht_amount'], 2, ',', ' ') ?></td>
								  		<td class="text-right"><?=$dataDevis['tva_amount'] ?></td>
								  		<td class="text-right"><?=number_format($dataDevis['ttc_amount'], 2, ',', ' ') ?></td>
								  	</tr>

								  	<tr <?php if($cpt2%2){echo 'class=""';}else{echo 'class="devis-striped"';};?>>
								  		<th colspan="2" class="text-right ">Complément devis</th>
								  		<td colspan="5"><?=$dataDevis['description'] ?></td>
								  	</tr>

									<?php $cpt++;?>

						 		<?php endif; ?>					  	
						  	 
						 		<?php $cpt2++; ?>

						  	<?php endforeach; ?>
	                        
	                        <?php if($cpt == 0):?>
	                            <tr>
	                                <td colspan="7" class="text-danger">Aucune proposition de devis sur cette catégorie.</td>
	                            </tr>
	                        <?php endif;?>
	                        <?php $cpt=0;?>
						 
						</tbody>
						
				   	</table>

			   	</div>
		</div>
	</div>
	<?php endforeach; ?>

	<div class="row" >
		<div class="col-md-8"></div>
		<div class="col-md-2 ">
			<strong>Total TTC :</strong>
		</div>
		<div class="col-md-2 text-right "><span id="totalResult">0.00 €</span></div>
	</div>
	
	<div class="row">
		<div class="col-md-4 col-md-offset-8">
			<button type="submit" class="btn btn-devirama btn-block">Accepter</button>
		</div>
	</div>
	<div id="inputHidden"></div>
</form>

<?php endif; ?>

	</div>
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
