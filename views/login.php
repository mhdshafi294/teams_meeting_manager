<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<head>
    <title>Teams Meetings Maneger</title>
</head>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div>
                            <div class="_buttons">
                                <a href="#" class="btn btn-xs btn-info btn-with-tooltip toggle-small-view hidden-xs pull-right hidden mleft10" id="toggleTableBtn" onclick="toggle_meeting_notes_table(); return false;" data-toggle="tooltip" title="" data-original-title="Toggle Table">
                                    <i class="fa fa-angle-double-right"></i>
                                </a>
                            </div>

                            <h3 class='text-center'>
                                <a href="<?= admin_url('teams_meeting_manager/meetings/signin'); ?>">
                                    Login with Teams
                                </a>
                            </h3>

                            <h2 class='text-center'>Teams Meeting Manager</h2>
                            <hr class="hr-panel-heading">
                            <table class="table dt-table dt-inline scroll-responsive" id="meetings">

                            </table>
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