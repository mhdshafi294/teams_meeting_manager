<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
/**
 * Current meeting
 */
init_head();
?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div style="display: flex;justify-content:center;">
                            <div class="meeting_info_headers">
                                <h4>Meeting Information</h4>
                            </div>
                        </div>
                        <hr class="hr-panel-heading">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4><strong>Subject:</strong> <?= $meeting["subject"] ?></h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Description:</strong> <?= $meeting["description"] ?></h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4 class="<?= (ucfirst($meeting->status) === 'Started') ? 'text-success' : 'text-info' ?>" data-toggle="tooltip" title="After clicking on the Start URL your browser will open new tab, after the tab is fully loaded you can close the tab. Then you can join the meeting by click in Join URL(Web)">
                                    <strong>Status:</strong>
                                    <?= ucfirst($meeting->status) ?>
                                    <?php if ($meeting->status === 'waiting') : ?>
                                        <a class="pull-right" href="<?= $meeting->start_url; ?>" target="_blank"><strong>Start URL</strong></a>
                                    <?php endif; ?>
                                </h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Start Time:</strong>
                                    <?= _dt($meeting["start"]["dateTime"]) ?></h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Duration:</strong>
                                    <?php
                                    $startDate = new DateTime($meeting["start"]["dateTime"]);
                                    $endDate = new DateTime($meeting["end"]["dateTime"]);
                                    $duration = $startDate->diff($endDate);
                                    ?>
                                    <?= $duration->h . " hours " . $duration->m . " minutes "; ?></h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Time Zone:</strong> <?= $meeting["originalStartTimeZone"]; ?></h4>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4><strong>Meeting Type:</strong>
                                    <?= $meeting["type"] ?></h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Allow participants to join the meeting before the host starts the meeting.:</strong>
                                    <?= ($settings->join_before_host) ? _l('yes') : _l('no'); ?></h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4>
                                    <a href="<?= str_replace('j/', 'wc/join/', $meeting["onlineMeeting"]["joinUrl"]); ?>" target="_blank">
                                        <strong>Join URL</strong>
                                    </a>
                                </h4>
                                <hr>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <a href="<?= admin_url('teams_meeting_manager/meetings/index'); ?>" class="btn btn-default btn-xs">Back To Meetings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php init_tail(); ?>
<script>
    /**
     * Just toggles the menu to be active
     */
    $('.menu-item-zoom_meeting_manager').addClass('active');
</script>
</body>

</html>