<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/realms.css">
                <link rel="stylesheet" href="/public/css/_404.css">
<? if (count($realms) > 0) { ?>
                <div class="section">
                    <div class='header'><?=$subtitle?></div>
                    <div class="content">
                        <div class="subheader">List of our current realms:</div>
                        <div class="table status">
                            <div class="header">
                                <div class="name">Name</div>
                                <div class="type">Type</div>
                                <div class="population">Population</div>
                                <div class="status">Status</div>
                                <div class="uptime">Uptime</div>
                            </div>
<? foreach ($realms as $realm) { ?>
                            <div class="row<?=' ' . $realm['version'][0]?>">
                                <div class="name">
                                    <img data-tooltip="<?=$realm['version'][1]?>" alt="<?=$realm['version'][1]?>" src="/public/img/icon/version/<?=$realm['version'][0]?>.webp"/>
                                    <?=$realm['name']?>
                                </div>
                                <div class="type"><?=$realm['type']?></div>
                                <div class="population"><?=$realm['population']?></div>
                                <div class="status <?=$realm['status']?>"><?=ucfirst($realm['status'])?></div>
                                <div class="uptime"><?=$realm['uptime']?></div>
                            </div>
<? } ?>
                        </div>
<? if (MANGOSD_SHOW_UPTIME_HISTORY) { ?>
<? foreach ($realms as $realm) { ?>
                        <div class="subheader">
                            <div>Uptime history for our <div class='name'><?=$realm['name']?></div> realm:</div>
                        </div>
                        <div class="table history">
                            <div class="header">
                                <div class="name">Name</div>
                                <div class="type">Type</div>
                                <div class="players">Players</div>
                                <div class="started">Started</div>
                                <div class="uptime">Uptime</div>
                            </div>
<? if (count($realm['history']) > 0) { ?>
<? foreach ($realm['history'] as $history) { ?>
                            <div class="row<?=' ' . $realm['version'][0]?>">
                                <div class="name">
                                    <img data-tooltip="<?=$realm['version'][1]?>" alt="<?=$realm['version'][1]?>" src="/public/img/icon/version/<?=$realm['version'][0]?>.webp"/>
                                    <?=$history['name']?>
                                </div>
                                <div class="type"><?=$realm['type']?></div>
                                <div class="players"><?=$history['players']?></div>
                                <div class="started <?=$history['started']?>"><?=$history['started']?></div>
                                <div class="uptime"><?=$history['uptime']?></div>
                            </div>
<? } } else { ?>
                            <div class="row error">
                                <div>There is no uptime history for the realm.</div>
                            </div>
<? } ?>
                        </div>
<? } ?>
                    </div>
                </div>
<? } ?>
<? } else { ?>
                <div class="section _404">
                    <div class="header">Status</div>
                    <div class="content">
                        <div class="warning">
                            <p>“I couldn't find any realms in the database.”</p>
                        </div>
                        <div class="orc"></div>
                    </div>
                </div>
<? } ?>
<? include('./application/views/footer.php'); ?>