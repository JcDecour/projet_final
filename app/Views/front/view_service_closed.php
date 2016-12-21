<?php $this->layout('layout', ['title' => 'Consultation d\'un devis']) ?>

<?php $this->start('main_content') ?>

<div class="content-site">
    
	<div class="page-header">
		<h1>Consultation du service cloturé</h1>
	</div>
    
    <!--Partie entete du devis (Récapitulatif)-->
        <!-- Code postal du lieu du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Code postal du lieu du service:</label>  
		<div class="col-md-9"><?=$project['zip_code'];?></div>
	</div>

	   <!-- Objet du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Objet du service:</label>  
		<div class="col-md-9"><?=$project['title'];?></div>
	</div>

	<br>

	   <!-- Description du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Description:</label>  
		<div class="col-md-7 withbackground"><?=nl2br($project['description']);?></div>
	</div>
    
    <br>
    
        <!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Date prévisionnelle:</label>  
		<div class="col-md-9"><?=DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');?></div>
	</div>
    
    <br>
    
    <!-- Partie devis par catégrorie / ss-categorie-->
    <?php foreach($projectSubSectors as $key => $projectSubSector): ?>
    
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <?=$projectSubSector['sectorTitle'];?>&nbsp;-&nbsp;<?=$projectSubSector['subsectorTitle'];?>
            </div>
            
            <?php if(empty($projectSubSector['id_provider'])): ?>
                <div class="panel-body">
                     Aucun devis retenu pour cette catégorie.
                </div>
            <?php else:;?>
                <div class="panel-body">
                    
                    <!--Coordonnées du provider-->
                    <div class="jumbotron jumbotrondevis">
                        <address>
                            <strong>Coordonnées du professionel à contacter:</strong><br>
                            <?=$projectSubSector['providerCompanyName'];?><br>
                            <?=$projectSubSector['providerCivilite'];?>&nbsp;<?=$projectSubSector['providerLastname'];?>&nbsp;<?=$projectSubSector['providerFirstname'];?><br>
                             <?=$projectSubSector['providerStreet'];?>&nbsp;<?=$projectSubSector['providerZipcode'];?>&nbsp;<?=$projectSubSector['providerCity'];?><br>
                            Tél fixe:&nbsp;<?=$projectSubSector['providerFixedphone'];?><br>
                            Tél mobile:&nbsp;<?=$projectSubSector['providerMobilephone'];?><br>
                        </address>
                        
                        <address>
                            <strong>Mail:</strong><br>
                            <?=$projectSubSector['providerEmail'];?>
                        </address>
                    </div>
                    
                    <!--Informations complémenatires du devis-->
                    <div class="row">
                        <label class="col-md-12 control-label" for="description">Informations complémentaires du devis:</label>
                        <div class="col-md-12">
                            <?=$projectSubSector['description'];?>
                        </div>
                    </div>
                </div>
            
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Désignation</th>
                            <th class="text-right">Montant HT(€)</th>
                            <th class="text-right">Taux de TVA(%)</th>
                            <th class="text-right">Montant TTC(€)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?=$projectSubSector['designation'];?>
                            </td>
                            <td class="text-right-basic-table">
                                <?=number_format($projectSubSector['ht_amount'], 2 , "." , " ");?>
                            </td>
                            <td class="text-right-basic-table">
                                 <?=$projectSubSector['tva_amount'];?>
                            </td>
                            <td class="text-right-basic-table">
                                <span id="ttc_amount"><?=number_format($projectSubSector['ht_amount'] * (1  + ($projectSubSector['tva_amount'] / 100)), 2 , "." , " ");?></span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            
            <?php endif; ?>
        </div>
    
       
    
    <?php endforeach; ?>
    
    <!--Bouton de retour à la liste des devis-->
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="<?=$this->url('front_list_services');?>" class="btn btn-default" title="Retour liste des devis">Retour liste</a>
        </div>
    </div>
    
</div>

<?php $this->stop('main_content') ?>