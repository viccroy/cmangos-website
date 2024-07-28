<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/account.css">
                <div class="section logs">
                    <div class="header"><?=$subtitle?></div>
                    <div class="content">
                        <div class="subheader">Your access logs for the last <?=ACCOUNT_ACCESS_LOGS_DAYS?> days:</div>
                        <div class="table">
                            <div class="header">
                                <div class="id">#</div>
                                <div class="time">Time</div>
                                <div class="ip">IP</div>
                                <div class="source">Source</div>
                            </div>
<? if (count($logs) > 0) { ?>
<? foreach ($logs as $index => $log) { ?>
                            <div class="row<?=' ' . $log['version'][0]?>">
                                <div class="id"><?=$index+1?></div>
                                <div class="time"><?=date("d-m-y H:i:s", strtotime($log['time']))?></div>
                                <div class="ip"><?=$log['ip']?></div>
                                <div class="source">
                                    <img
                                        data-tooltip="<?=$log['version'][1]?>"
                                        alt="<?=$log['version'][1]?>"
                                        src="/public/img/icon/version/<?=$log['version'][0]?>.webp"/>
                                    <?=$log['source']?>
                                </div>
                            </div>
<? } } else { ?>
                            <div class="row error">
                                <div>You currently have no access logs.</div>
                            </div>
<? } ?>
                        </div>
                    </div>
                </div>
<? include('./application/views/footer.php'); ?>