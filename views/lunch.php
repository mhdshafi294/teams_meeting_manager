<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
     <div class="content">
          <div class="row">
               <div class="col-md-12">
                    <div class="panel_s">
                         <div class="panel-body">
                              <div>
                                   <h4>Teams Meeting Manager</h4>
                                   <hr class="hr-panel-heading">
                                   <iframe src="<?= $link ?>" title="Teams meeting" width="99%" height="500" style="border:none"></iframe>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
<?php init_tail(); ?>
</body>

</html>

<script>
     init_selectpicker();
     // Menu
     $('.menu-item-teams_meeting_manager').toggleClass('active');
</script>