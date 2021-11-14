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
                            <h4>Teams Meeting Manager</h4>
                            <hr class="hr-panel-heading">
                            <table class="table dt-table dt-inline scroll-responsive" id="meetings">
                                <?php $this->load->view('partials/index-table-contents', $data2); ?>
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