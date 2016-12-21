<?php $this->layout('layout', ['title' => 'Consultation d\'un devis']) ?>

<?php $this->start('main_content') ?>

<div class="content-site">
    
	<div class="page-header">
		<h1>Consultation d'un devis</h1>
	</div>
    
   <!-- Gestion du status du devis-->
    <?php if($devis['accepted']): ?>
        <p class="devis_status accepted">Votre devis est dans l'état: "Accepté"</p>
    <?php elseif($devis['projectClosed']):?>
        <p class="devis_status not_accepted">Votre devis est dans l'état: "Non retenu"</p>
    <?php else: ?>
        <p class="devis_status pending">Votre devis est dans l'état: "Non statué"</p>
    <?php endif; ?>
    
     <!--Partie coordonnées du client-->
    <?php if($devis['accepted']): ?>
        <div class="jumbotron jumbotrondevis">
            <address>
                <strong>Coordonnées du client à contacter:</strong><br>
                <?=$devis['civilite'];?>&nbsp;<?=$devis['lastname'];?>&nbsp;<?=$devis['firstname'];?><br>
                <?=$devis['street'];?>&nbsp;<?=$devis['zipcode'];?>&nbsp;<?=$devis['city'];?><br>
                Tél fixe:&nbsp;<?=$devis['fixed_phone'];?><br>
                Tél mobile:&nbsp;<?=$devis['mobile_phone'];?><br>
            </address>

            <address>
                <strong>Mail:</strong><br>
                <?=$devis['email'];?>
            </address>
        </div>
    <?php endif; ?>
    
    <br>
    
    <!--Partie entete du devis (Récapitulatif)-->
    <!-- N° de l'offre -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="num_offre">N° Offre:</label>  
		<div class="col-md-9"><?=sprintf("%06d", $devis['projectId'])?>&nbsp;( Ajoutée le <?=DateTime::createFromFormat('Y-m-d H:i:s', $devis['created_at'])->format('d/m/Y');?> )</div>
	</div>
    
        <!-- Code postal du lieu du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Code postal du lieu du service:</label>  
		<div class="col-md-9"><?=$devis['projectZipCode'];?></div>
	</div>

	   <!-- Objet du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Objet du service:</label>  
		<div class="col-md-9"><?=$devis['projectTitle'];?></div>
	</div>

	<br>

         <!-- Catégorie / Ss Catégorie du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Catégorie / Sous Catégorie:</label>
		<div class="col-md-9"><span class="tag label label-categories"><?=$devis['titleSector'];?> - <?=$devis['titleSubsector'];?></span></div> 
	</div>
    
    <br>
    
	   <!-- Description du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Description:</label>  
		<div class="col-md-7 withbackground"><?=nl2br($devis['projectDescription']);?></div>
	</div>
    
    <br>
    
        <!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Date prévisionnelle:</label>  
		<div class="col-md-9"><?=DateTime::createFromFormat('Y-m-d', $devis['projectPredicted'])->format('d/m/Y');?></div>
	</div>
    
    <br>
    
    
   <!-- Partie devis-->
    <div class="panel panel-default">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Devis&nbsp;N°&nbsp;<?=sprintf("%06d", $devis['id'])?>&nbsp;( Ajouté le <?=DateTime::createFromFormat('Y-m-d H:i:s', $devis['created_at'])->format('d/m/Y');?> )</div>
			<div class="panel-body">

				<div class="row">
					<label class="col-md-12 control-label" for="description">Informations complémentaires:</label>
					<div class="col-md-12">
						<?=$devis['description'];?>
                    </div>
				</div>
			</div>
        
            <table class="table table-bordered">
				<thead>
					<tr>
						<th>Désignation</th>
						<th class="text-right">Montant HT (€)</th>
						<th class="text-right">Taux de TVA (%)</th>
						<th class="text-right">Montant TTC (€)</th>
					</tr>
				</thead>
                <tbody>
					<tr>
						<td>
							<?=$devis['designation'];?>
						</td>
						<td class="text-right-basic-table">
				            <?=number_format($devis['ht_amount'], 2 , "." , " ");?>
						</td>
						<td class="text-right-basic-table">
							 <?=$devis['tva_amount'];?>
						</td>
						<td class="text-right-basic-table">
							<span id="ttc_amount"><?=number_format($devis['ht_amount'] * (1  + ($devis['tva_amount'] / 100)), 2 , "." , " ");?></span>
						</td>
					</tr>
				</tbody>
            </table>
        
    </div>
    
    <!--Bouton de retour à la liste des devis-->
    <div class="row">
        <div class="col-md-12 text-right">

            <a href="<?=$this->url('front_devis_list');?>" class="btn btn-devirama" title="Retour liste des devis">Retour liste</a>

        </div>
    </div>
</div>

<?php $this->stop('main_content') ?>