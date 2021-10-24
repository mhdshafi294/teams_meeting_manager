<?php defined('BASEPATH') or exit('No direct script access allowed');

$__teamsAppId = get_option('tmm_app_id');
$_teamsAppSecret = get_option('tmm_app_secret');
$_teamsAppRedirectUri = get_option('tmm_app_redirect_uri');

if (is_admin()) : ?>
     <h4>Teams API Settings</h4>
     <hr>
     <div class="form-group">
          <label for="tmm_app_id">Client ID</label>
          <input type="text" class="form-control" value="<?= $__teamsAppId; ?>" id="tmm_app_id" name="settings[tmm_app_id]">
     </div>
     <div class="form-group">
          <label for="tmm_app_secret">Client Secret</label>
          <input type="text" class="form-control" value="<?= $_teamsAppSecret; ?>" id="tmm_app_secret" name="settings[tmm_app_secret]">
     </div>
     <div class="form-group">
          <div class="alert alert-info alert-dismissible mtop15" role="alert">
               Teams Authorization Redirect URI:: <strong> <?= $_teamsAppRedirectUri; ?></strong>
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
               </button>
          </div>
     </div>
<?php endif;

update_option('tmm_app_id', $__teamsAppId);
update_option('tmm_app_secret', $_teamsAppSecret);
update_option('tmm_app_redirect_uri', $_teamsAppRedirectUri);
?>