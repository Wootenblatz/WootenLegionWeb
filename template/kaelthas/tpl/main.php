<?php

/**
 * Created by Amin.MasterkinG
 * Website : wootenmane.wootenblatz.com
 * Email : lichwow_masterking@yahoo.com
 * Date: 11/26/2018 - 8:36 PM
 */
require_once 'header.php'; ?>
<div class="row">
    <div class="col-md-8">
        <div>
            <ul class="nav nav-tabs" style="display: none;">
                <li><a data-toggle="tab" href="#pills-register" id="register">Register</a></li>
                <li><a data-toggle="tab" href="#pills-howtoconnect" id="howtoconnect">How to Connect</a></li>
                <li><a data-toggle="tab" href="#pills-serverstatus" id="serverstatus">Server Status</a></li>
                <li><a data-toggle="tab" href="#pills-topplayers" id="topplayers">Top Players</a></li>
                <li><a data-toggle="tab" href="#pills-contact" id="contact">Contact us</a></li>
            </ul>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade in <?php echo ((empty($error_error) && empty($success_msg)) ? 'active' : ''); ?>" id="pills-main">
                    <?php require_once base_path . 'template/' . $antiXss->xss_clean(get_config("template")) . '/tpl/posts.php'; ?>
                </div>
                <div class="tab-pane fade in <?php echo (!(empty($error_error) && empty($success_msg)) ? 'active' : ''); ?>" id="pills-register">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="" method="post">
                                <div class="box1" style="margin-top: 10px;padding: 10px;">
                                    <?php error_msg();
                                    success_msg(); //Display message. 
                                    ?>

                                    <?php if(empty($success_msg)) { ?>
                                        <div class="input-group">
                                            <span class="input-group">Wootenmane Email (fake bnet)</span>
                                            <input type="email" class="form-control required" placeholder="Email" name="email">
                                        </div>
                                        <?php if (!get_config('battlenet_register')) { ?>
                                            <div class="input-group">
                                                <span class="input-group">Username</span>
                                                <input type="text" class="form-control required" placeholder="Username" name="username">
                                            </div>
                                        <?php } ?>
                                        <?php if (get_config('battlenet_register')) { ?>
                                            <div class="input-group">
                                                <span class="input-group">Number of accounts</span>
                                                <input type="number" class="form-control required" placeholder="Type a number from 1 to 5" name="numberOfAccounts" min="1" max="5" step="1">
                                            </div>
                                        <?php } ?>
                                        <div class="input-group">
                                            <span class="input-group">Password</span>
                                            <input type="password" class="form-control required" placeholder="Password" name="password">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group">Re-Password</span>
                                            <input type="password" class="form-control required" placeholder="Confirm password" name="repassword">
                                        </div>
                                        <input name="submit" type="hidden" value="register">
                                        <div class="text-center" ><input type="submit" class="btn btn-success" value="Register">
                                        </div>

                                    <?php } ?>

                                    <?php $success_msg = null; ?>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="box1" style="margin-top: 10px;padding: 10px;text-align: left">
                                <?php require_once base_path . 'template/' . $antiXss->xss_clean(get_config("template")) . '/tpl/rules.php'; ?>
                                <hr>
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changepassword-modal">
                                        Change Password
                                    </button>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#restorepassword-modal">
                                        Restore Password
                                    </button>
                                </div>
                                <div class="modal" id="restorepassword-modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Restore Password</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post">
                                                    <div class="input-group">
                                                        <span class="input-group">Email</span>
                                                        <input type="email" class="form-control" placeholder="Email" name="email">
                                                    </div>
                                                    <input name="submit" type="hidden" value="restorepassword">
                                                    <div class="text-center" ><input type="submit" class="btn btn-primary" value="Change Password"></div>

                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal" id="changepassword-modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Change Password</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post">
                                                    <div class="input-group">
                                                        <span class="input-group">Email</span>
                                                        <input type="email" class="form-control" placeholder="Email" name="email">
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group">Old Password</span>
                                                        <input type="password" class="form-control" placeholder="Old Password" name="old_password">
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group">Password</span>
                                                        <input type="password" class="form-control" placeholder="Password" name="password">
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group">Re-Password</span>
                                                        <input type="password" class="form-control" placeholder="Re-Password" name="repassword">
                                                    </div>
                                                    <input name="submit" type="hidden" value="changepass">
                                                    <div class="text-center" ><input type="submit" class="btn btn-primary" value="Change Password"></div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="pills-howtoconnect">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box1" style="margin-top: 10px;padding: 10px;text-align: left">
                                <?php require_once base_path . 'template/' . $antiXss->xss_clean(get_config("template")) . '/tpl/howtoconnect.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="pills-serverstatus">
                    <div class="box1" >
                        <?php
                        foreach (get_config('realmlists') as $onerealm_key => $onerealm) {
                            echo "<p><span >{$onerealm['realmname']}</span> <span style='font-size: 12px;'>(Limited to show 49 player - Online players : " . user::get_online_players_count($onerealm['realmid']) . ")</span></p><hr>";
                            $online_chars = user::get_online_players($onerealm['realmid']);
                            if (!is_array($online_chars)) {
                                echo "<span >No have Online player.</span>";
                            } else {
                                echo '<table class="table table-dark"><thead><tr><th scope="col">Name</th><th scope="col">Race</th> <th scope="col">Class</th><th scope="col">Level</th></tr></thead><tbody>';
                                foreach ($online_chars as $one_char) {
                                    echo '<tr><th scope="row">' . $antiXss->xss_clean($one_char['name']) . '</th><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/race/' . $antiXss->xss_clean($one_char["race"]) . '-' . $antiXss->xss_clean($one_char["gender"]) . '.gif\'></td><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/class/' . $antiXss->xss_clean($one_char["class"]) . '.gif\'></td><td>' . $antiXss->xss_clean($one_char['level']) . '</td></tr>';
                                }
                                echo '</table>';
                            }
                            echo "<hr>";
                        }
                        ?>
                    </div>
                </div>
                <div class="tab-pane fade in" id="pills-topplayers">
                    <div class="box1">
                        <?php
                        $i = 1;
                        foreach (get_config('realmlists') as $onerealm_key => $onerealm) {
                            echo "<h1>{$onerealm['realmname']}</h1><hr>";

                            $data2show = status::get_top_playtime($onerealm['realmid']);
                            echo "<button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#modal-id$i\">Play Time</button><div class=\"modal\" id=\"modal-id$i\"><div class=\"modal-dialog modal-lg\"><div class=\"modal-content\">
                                        <div class=\"modal-header\"><h4 class=\"modal-title\">TOP PLAYERS - Play Time</h4><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button></div><div class=\"modal-body\">";

                            if (!is_array($data2show)) {
                                echo "<span >Don't have anything for display.</span>";
                            } else {
                                echo '<table class="table table-dark"><thead><tr><th scope="col">Rank</th><th scope="col">Name</th><th scope="col">Race</th> <th scope="col">Class</th><th scope="col">Level</th><th scope="col">Play Time</th></tr></thead><tbody>';
                                $m = 1;
                                foreach ($data2show as $one_char) {
                                    echo '<tr><td>' . $m++ . '<th scope="row">' . $antiXss->xss_clean($one_char['name']) . '</th><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/race/' . $antiXss->xss_clean($one_char["race"]) . '-' . $antiXss->xss_clean($one_char["gender"]) . '.gif\'></td><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/class/' . $antiXss->xss_clean($one_char["class"]) . '.gif\'></td><td>' . $antiXss->xss_clean($one_char['level']) . '</td><td>' . $antiXss->xss_clean(get_human_time_from_sec($one_char['totaltime'])) . '</td></tr>';
                                }
                                echo '</table>';
                            }
                            echo "</div><div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button></div></div></div></div>";
                            $i++;

                            //                                    $data2show = status::get_top_achievements($onerealm['realmid']);
                            //                                    echo "<button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#modal-id$i\">Play Achievements</button><div class=\"modal\" id=\"modal-id$i\"><div class=\"modal-dialog modal-lg\"><div class=\"modal-content\">
                            //                                            <div class=\"modal-header\"><h4 class=\"modal-title\">TOP PLAYERS - Achievements</h4><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button></div><div class=\"modal-body\">";
                            //                                    if (!is_array($data2show)) {
                            //                                        echo "<span >Don't have anything for display.</span>";
                            //                                    } else {
                            //                                        echo '<table class="table table-dark"><thead><tr><th scope="col">Rank</th><th scope="col">Name</th><th scope="col">Race</th> <th scope="col">Class</th><th scope="col">Level</th><th scope="col">Achievements</th></tr></thead><tbody>';
                            //                                        $m = 1;
                            //                                        foreach ($data2show as $one_char) {
                            //                                            $character_data = status::get_character_by_guid($onerealm['realmid'], $one_char['guid']);
                            //                                            if (empty($character_data['name'])) {
                            //                                                continue;
                            //                                            }
                            //                                            echo '<tr><td>' . $m++ . '<th scope="row">' . $antiXss->xss_clean($character_data['name']) . '</th><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/race/' . $antiXss->xss_clean($character_data["race"]) . '-' . $antiXss->xss_clean($character_data["gender"]) . '.gif\'></td><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/class/' . $antiXss->xss_clean($character_data["class"]) . '.gif\'></td><td>' . $antiXss->xss_clean($character_data['level']) . '</td><td>' . $antiXss->xss_clean($one_char['total']) . '</td></tr>';
                            //                                        }
                            //                                        echo '</table>';
                            //                                    }
                            //                                    echo "</div><div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button></div></div></div></div>";
                            //                                    $i++;

                            $data2show = status::get_top_killers($onerealm['realmid']);
                            echo "<button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#modal-id$i\">Killers</button><div class=\"modal\" id=\"modal-id$i\"><div class=\"modal-dialog modal-lg\"><div class=\"modal-content\">
                                        <div class=\"modal-header\"><h4 class=\"modal-title\">TOP PLAYERS - Kills</h4><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button></div><div class=\"modal-body\">";
                            if (!is_array($data2show)) {
                                echo "<span >Don't have anything for display.</span>";
                            } else {
                                echo '<table class="table table-dark"><thead><tr><th scope="col">Rank</th><th scope="col">Name</th><th scope="col">Race</th> <th scope="col">Class</th><th scope="col">Level</th><th scope="col">Kills</th></tr></thead><tbody>';
                                $m = 1;
                                foreach ($data2show as $one_char) {
                                    echo '<tr><td>' . $m++ . '<th scope="row">' . $antiXss->xss_clean($one_char['name']) . '</th><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/race/' . $antiXss->xss_clean($one_char["race"]) . '-' . $antiXss->xss_clean($one_char["gender"]) . '.gif\'></td><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/class/' . $antiXss->xss_clean($one_char["class"]) . '.gif\'></td><td>' . $antiXss->xss_clean($one_char['level']) . '</td><td>' . $antiXss->xss_clean($one_char['totalKills']) . '</td></tr>';
                                }
                                echo '</table>';
                            }
                            echo "</div><div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button></div></div></div></div>";
                            $i++;

                            $data2show = status::get_top_honorpoints($onerealm['realmid']);
                            echo "<button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#modal-id$i\">Honor Point</button><div class=\"modal\" id=\"modal-id$i\"><div class=\"modal-dialog modal-lg\"><div class=\"modal-content\">
                                        <div class=\"modal-header\"><h4 class=\"modal-title\">TOP PLAYERS - Honor Point</h4><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button></div><div class=\"modal-body\">";
                            if (!is_array($data2show)) {
                                echo "<span >Don't have anything for display.</span>";
                            } else {
                                echo '<table class="table table-dark"><thead><tr><th scope="col">Rank</th><th scope="col">Name</th><th scope="col">Race</th> <th scope="col">Class</th><th scope="col">Level</th><th scope="col">Honor Points</th></tr></thead><tbody>';
                                $m = 1;
                                foreach ($data2show as $one_char) {
                                    echo '<tr><td>' . $m++ . '<th scope="row">' . $antiXss->xss_clean($one_char['name']) . '</th><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/race/' . $antiXss->xss_clean($one_char["race"]) . '-' . $antiXss->xss_clean($one_char["gender"]) . '.gif\'></td><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/class/' . $antiXss->xss_clean($one_char["class"]) . '.gif\'></td><td>' . $antiXss->xss_clean($one_char['level']) . '</td><td>' . $antiXss->xss_clean($one_char['totalHonorPoints']) . '</td></tr>';
                                }
                                echo '</table>';
                            }
                            echo "</div><div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button></div></div></div></div>";
                            $i++;

                            $data2show = status::get_top_arenapoints($onerealm['realmid']);
                            echo "<button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#modal-id$i\">Arena Point</button><div class=\"modal\" id=\"modal-id$i\"><div class=\"modal-dialog modal-lg\"><div class=\"modal-content\">
                                        <div class=\"modal-header\"><h4 class=\"modal-title\">TOP PLAYERS - Arena Point:</h4><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button></div><div class=\"modal-body\">";
                            if (!is_array($data2show)) {
                                echo "<span >Don't have anything for display.</span>";
                            } else {
                                echo '<table class="table table-dark"><thead><tr><th scope="col">Rank</th><th scope="col">Name</th><th scope="col">Race</th> <th scope="col">Class</th><th scope="col">Level</th><th scope="col">Arena Points</th></tr></thead><tbody>';
                                $m = 1;
                                foreach ($data2show as $one_char) {
                                    echo '<tr><td>' . $m++ . '<th scope="row">' . $antiXss->xss_clean($one_char['name']) . '</th><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/race/' . $antiXss->xss_clean($one_char["race"]) . '-' . $antiXss->xss_clean($one_char["gender"]) . '.gif\'></td><td><img src=\'/template/' . $antiXss->xss_clean(get_config("template")) . '/images/class/' . $antiXss->xss_clean($one_char["class"]) . '.gif\'></td><td>' . $antiXss->xss_clean($one_char['level']) . '</td><td>' . $antiXss->xss_clean($one_char['arenaPoints']) . '</td></tr>';
                                }
                                echo '</table>';
                            }
                            echo "</div><div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button></div></div></div></div>";
                            $i++;

                            $data2show = status::get_top_arenateams($onerealm['realmid']);
                            echo "<button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#modal-id$i\">Arena Team</button><div class=\"modal\" id=\"modal-id$i\"><div class=\"modal-dialog modal-lg\"><div class=\"modal-content\">
                                        <div class=\"modal-header\"><h4 class=\"modal-title\">TOP PLAYERS - Arena Team</h4><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button></div><div class=\"modal-body\">";
                            if (!is_array($data2show)) {
                                echo "<span >Don't have anything for display.</span>";
                            } else {
                                echo '<table class="table table-dark"><thead><tr><th scope="col">Rank</th><th scope="col">Name</th><th scope="col">Rating</th><th scope="col">Captain Name</th></tr></thead><tbody>';
                                $m = 1;
                                foreach ($data2show as $one_char) {
                                    $character_data = status::get_character_by_guid($onerealm['realmid'], $one_char['captainGuid']);
                                    echo '<tr><td>' . $m++ . '<th scope="row">' . $antiXss->xss_clean($one_char['name']) . '</th><td>' . $antiXss->xss_clean($one_char['rating']) . '</td><td>' . (!empty($character_data["name"]) ? $antiXss->xss_clean($character_data['name']) : '-') . '</td></tr>';
                                }
                                echo '</table>';
                            }
                            echo "</div><div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button></div></div></div></div>";
                            $i++;

                            //                                    $data2show = status::get_top_guild_by_member($onerealm['realmid']);
                            //                                    echo "<button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#modal-id$i\">Guilds by member count</button><div class=\"modal\" id=\"modal-id$i\"><div class=\"modal-dialog modal-lg\"><div class=\"modal-content\">
                            //                                            <div class=\"modal-header\"><h4 class=\"modal-title\">TOP PLAYERS - Guilds by member count</h4><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button></div><div class=\"modal-body\">";
                            //                                    if (!is_array($data2show)) {
                            //                                        echo "<span >Don't have anything for display.</span>";
                            //                                    } else {
                            //                                        echo '<table class="table table-dark"><thead><tr><th scope="col">Rank</th><th scope="col">Name</th><th scope="col">Guild Leader</th></tr></thead><tbody>';
                            //                                        $m = 1;
                            //                                        foreach ($data2show as $one_char) {
                            //                                            $character_data = status::get_character_by_guid($onerealm['realmid'], $one_char['leaderguid']);
                            //                                            echo '<tr><td>' . $m++ . '<th scope="row">' . $antiXss->xss_clean($one_char['name']) . '</th><td>' . (!empty($character_data["name"]) ? $antiXss->xss_clean($character_data['name']) : '-') . '</td></tr>';
                            //                                        }
                            //                                        echo '</table>';
                            //                                    }
                            //                                    echo "</div><div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button></div></div></div></div>";
                            //                                    $i++;

                            echo "<hr>";
                        }
                        ?>
                    </div>
                </div>
                <div class="tab-pane fade in" id="pills-contact">
                    <div class="box1">
                        <?php require_once base_path . 'template/' . $antiXss->xss_clean(get_config("template")) . '/tpl/contactus.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 sidebar">
        <div class="box1">
            SERVER INFO
            <hr style="border-color: #F1A40F;">
            <p>Address: <span style="color: yellow;"><?php echo get_config('realmlist'); ?></span></p>
            <?php echo (!empty(get_config("game_version")) ? '<p>Version : <span style="color: yellow;">' . get_config("game_version") . '</span></p>' : ''); ?>
        </div>
    </div>
</div>
<?php require_once 'footer.php'; ?>