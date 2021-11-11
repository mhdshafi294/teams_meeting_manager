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
                                <h4><strong>Description:</strong>
                                    <?php
                                    $position = strpos($meeting["bodyPreview"], "___");
                                    if(!$position==0){
                                        $position = strpos($meeting["bodyPreview"], "\r\n");
                                        $result = substr($meeting["bodyPreview"], 0, $position);
                                    }else{
                                        $result ='No Discription';
                                    }
                                    echo $result;
                                    ?>
                                </h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Meeting Date:</strong>
                                    <?php
                                    $position = strpos($meeting["start"]["dateTime"], 'T');
                                    $result = substr($meeting["start"]["dateTime"], 0, $position);
                                    echo $result;
                                    ?>
                                </h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Start Time:</strong>
                                    <?php
                                    $position1 = strpos($meeting["start"]["dateTime"], 'T');
                                    $result = substr($meeting["start"]["dateTime"], $position1 + 1, 5);
                                    echo $result;
                                    ?>
                                </h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>End Time:</strong>
                                    <?php
                                    $position1 = strpos($meeting["end"]["dateTime"], 'T');
                                    $result = substr($meeting["end"]["dateTime"], $position1 + 1, 5);
                                    echo $result;
                                    ?>
                                    <!-- <?php
                                            $startDate = new DateTime($meeting["start"]["dateTime"]);
                                            $endDate = new DateTime($meeting["end"]["dateTime"]);
                                            $duration = $startDate->diff($endDate);
                                            ?>
                                <?= $duration->h . " hours " . $duration->m . " minutes "; ?> -->
                                </h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Time Zone:</strong> <?= $meeting["originalStartTimeZone"]; ?></h4>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4>
                                    <a href="<?= str_replace('j/', 'wc/join/', $meeting["onlineMeeting"]["joinUrl"]); ?>"
                                        target="_blank">
                                        <strong>Join URL</strong>
                                    </a>
                                </h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Meeting Type:</strong>
                                    <?= $meeting["type"] ?></h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Organizer:</strong>
                                    <?= $meeting["organizer"]["emailAddress"]["name"] ?></h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Allow participants to join the meeting before the host starts the
                                        meeting:</strong>
                                    Yes</h4>
                                <hr>
                            </div>

                            <div class="form-group">
                                <h4><strong>Attendees:</strong>
                                    <?php
                                    foreach ($meeting["attendees"] as $attend) {
                                        echo '<br>' . $attend["emailAddress"]["name"];
                                    }

                                    ?>
                                    <hr>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <a href="<?= admin_url('teams_meeting_manager/meetings/index'); ?>"
                            class="btn btn-default btn-xs">Back To Meetings</a>
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
$('.menu-item-teams_meeting_manager').toggleClass('active');
</script>
</body>

</html>