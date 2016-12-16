<?php $this->layout('layout', ['title' => 'Profil']) ?>
<?php $this->start('main_content') ?>
<div class="page-header">
  <h1 style="text-align: center;">Mon profil</h1>
</div>
<div class="forms">
  <form method="post" class="form-horizontal">
    <p class="text-required-filed">
    </p>
    <fieldset>
      <?php if(isset($formValid['valid'])): ?>
        <div class="alert alert-info" style="text-align:center;">
          <?=$formValid['valid'];?>
        </div>
      <?php elseif(isset($formErrors['global'])): ?>
        <div class="alert alert-danger" style="text-align:center;">
          <?=$formErrors['global'];?>
        </div>
      <?php endif; ?>
      <!-- Select civilité -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="civilité">Civilité :
        </label>
        <div class="col-md-2">
          <select id="civilité" name="civilité" class="form-control">
            <option value="" selected disabled><?=isset($customer['civilité']) ? $customer['civilité'] : '';?></option>
            <option value="Monsieur">Mr</option>
            <option value="Madame">Mme</option>
            <option value="Mademoiselle">Melle</option>
          </select>
        </div>
        <!-- Gestion des erreurs -->
        <?php if(isset($formErrors['civilité'])): ?>
        <div class="error col-md-offset-4 col-md-8"><?=$formErrors['civilité']?></div>
        <?php endif; ?>
      </div>
      <!-- Firstname-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="firstname">Prénom :
        </label>
        <div class="col-md-4">
          <input id="firstname" name="firstname" type="text" value="<?=isset($customer['firstname']) ? $customer['firstname'] : '';?>"  class="form-control input-md">
          
        </div>
        <!-- Gestion des erreurs -->
        <?php if(isset($formErrors['firstname'])): ?>
        <div class="error col-md-offset-4 col-md-8"><?=$formErrors['firstname']?></div>
        <?php endif; ?>
      </div>
      <!-- Lastname-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="lastname">Nom :
        </label>
        <div class="col-md-4">
          <input id="lastname" name="lastname" type="text" value="<?=isset($customer['lastname']) ? $customer['lastname'] : '';?>" class="form-control input-md">
          
        </div>
        <!-- Gestion des erreurs -->
        <?php if(isset($formErrors['lastname'])): ?>
        <div class="error col-md-offset-4 col-md-8"><?=$formErrors['lastname']?></div>
        <?php endif; ?>
      </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="email">Email:
          <span class="obligatoire">*</span>
        </label>
        <div class="col-md-4">
          <input id="email" name="email" type="email" class="form-control input-md" value="<?=isset($customer['email']) ? $customer['email'] : '';?>">
          
        </div>
        <!-- Gestion des erreurs -->
        <?php if(isset($formErrors['email'])): ?>
        <div class="error col-md-offset-4 col-md-8"><?=$formErrors['email']?></div>
        <?php endif; ?>
      </div>
      <!-- Password input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="password">Mot de passe:
        </label>
        <div class="col-md-4">
          <input id="password" name="password" type="password" class="form-control input-md">
          
        </div>
        <!-- Gestion des erreurs -->
        <?php if(isset($formErrors['password'])): ?>
        <div class="error col-md-offset-4 col-md-8"><?=$formErrors['password']?></div>
        <?php endif; ?>
      </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="fixed_phone">Téléphone fixe:
        </label>
        <div class="col-md-4">
          <input id="fixed_phone" name="fixed_phone" type="text" class="form-control input-md" value="<?=isset($customer['fixed_phone']) ? $customer['fixed_phone'] : '';?>">
          
        </div>
        <!-- Gestion des erreurs -->
        <?php if(isset($formErrors['fixed_phone'])): ?>
        <div class="error col-md-offset-4 col-md-8"><?=$formErrors['fixed_phone']?></div>
        <?php endif; ?>
      </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="mobile_phone">Téléphone mobile:
        </label>
        <div class="col-md-4">
          <input id="mobile_phone" name="mobile_phone" type="text"  class="form-control input-md" value="<?=isset($customer['mobile_phone']) ? $customer['mobile_phone'] : '';?>">
          
        </div>
        <!-- Gestion des erreurs -->
        <?php if(isset($formErrors['mobile_phone'])): ?>
        <div class="error col-md-offset-4 col-md-8"><?=$formErrors['mobile_phone']?></div>
        <?php endif; ?>
      </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="street">Adresse:
          <span class="obligatoire">*</span>
        </label>
        <div class="col-md-4">
          <input id="street" name="street" type="text" placeholder="Rue de la paix" class="form-control input-md" value="<?=isset($customer['street']) ? $customer['street'] : '';?>">
          
        </div>
        <!-- Gestion des erreurs -->
        <?php if(isset($formErrors['street'])): ?>
        <div class="error col-md-offset-4 col-md-8"><?=$formErrors['street']?></div>
        <?php endif; ?>
      </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="zipcode">Code postal:
          <span class="obligatoire">*</span>
        </label>
        <div class="col-md-2">
          <input id="zipcode" name="zipcode" type="text" placeholder="75000" class="form-control input-md" value="<?=isset($customer['zipcode']) ? $customer['zipcode'] : '';?>">
          
        </div>
        <!-- Gestion des erreurs -->
        <?php if(isset($formErrors['zipcode'])): ?>
        <div class="error col-md-offset-4 col-md-8"><?=$formErrors['zipcode']?></div>
        <?php endif; ?>
      </div>
      <!-- Text input-->
      <div class="form-group">
        <label class="col-md-4 control-label" for="city">Ville:
          <span class="obligatoire">*</span>
        </label>
        <div class="col-md-4">
          <input id="city" name="city" type="text" placeholder="Paris" class="form-control input-md" value="<?=isset($customer['city']) ? $customer['city'] : '';?>">
          
        </div>
        <!-- Gestion des erreurs -->
        <?php if(isset($formErrors['city'])): ?>
        <div class="error col-md-offset-4 col-md-8"><?=$formErrors['city']?></div>
        <?php endif; ?>
      </div>
      <!-- Button -->
      <div class="form-group">
        <label class="col-md-4 control-label" for="edit"></label>
        <div class="col-md-4">
          <button id="edit" name="edit" class="btn btn-info">Modifier le profil</button>
        </div>
      </div>
    </fieldset>
  </form>
</div>
<?php $this->stop('main_content') ?>