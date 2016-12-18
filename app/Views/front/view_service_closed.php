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
		<div class="col-md-9"><?=nl2br($project['description']);?></div>
	</div>
    
    <br>
    
        <!-- Date prévisionnelle du service -->
	<div class="row">
		<label class="col-md-3 control-label text-right" for="zip_code">Date prévisonnelle:</label>  
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
                     Absence de devis retenu pour cette catégorie.
                </div>
            <?php else:;?>
                <div class="panel-body">
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
                            <th>Montant HT (€)</th>
                            <th>Taux de TVA</th>
                            <th>Montant TTC (€)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?=$projectSubSector['designation'];?>
                            </td>
                            <td class="text-right">
                                <?=$projectSubSector['ht_amount'];?>
                            </td>
                            <td class="text-right">
                                 <?=$projectSubSector['tva_amount'];?>
                            </td>
                            <td class="text-right">
                                <span id="ttc_amount"><?=number_format($projectSubSector['ht_amount'] * (1  + ($projectSubSector['tva_amount'] / 100)), 2 , "." , " ");?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            
            <?php endif; ?>
        </div>
    
    <?php endforeach; ?>
    
    
</div>

<?php $this->stop('main_content') ?>