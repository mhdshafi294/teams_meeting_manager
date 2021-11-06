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
                            <h1 style="text-align:center;margin-top:50px;">Configuration data is missing.<br><br>
                                Navigate in <a href=<?= admin_url("/settings?group=teams-meeting-manager-settings") ?>>Settings-&gt;Teams
                                    Meeting Manager</a> to add your Teams APP ID and APP SECRET</h1>
                            <h3><a href=<?= admin_url("/settings?group=teams-meeting-manager-settings") ?> style="margin-left:50%;">[ Teams Settings ] </a></h3>
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