<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/realms.css">
                <link rel="stylesheet" href="/public/css/_404.css">
<? if (count($realms) > 0) { ?>
                <div class="section">
                    <div class='header'><?=$subtitle?></div>
                    <div class="content">
<? foreach ($realms as $realm) { ?>
                        <div class="subheader">
                            <div>Online players for our <div class='name'><?=$realm['name']?></div> realm:</div>
                        </div>
                        <div class="table players">
                            <div class="header">
                                <div class="id">#</div>
                                <div class="name">Name</div>
                                <div class="level">Level</div>
                                <div class="race">Race</div>
                                <div class="class">Class</div>
                                <div class="playtime">Playtime</div>
                            </div>
<? if (count($realm['players']) > 0) { ?>
<? foreach ($realm['players'] as $index => $player) { ?>
                            <div class="row<?=' ' . $realm['version'][0]?><?=' ' . lcfirst($player['faction'])?>">
                                <div class="id"><?=$index+1?></div>
                                <div class="name">
<? if (REALMS_ARMORY_ENABLED) { ?>
                                    <a href="/realms/armory/<?=$realm['id'] . '-' . $player['id']?>"><?=$player['name']?></a>
<? } else { ?>
                                    <?=$player['name']?>
<? } ?>
                                </div>
                                <div class="level"><?=$player['level']?></div>
                                <div class="race">
                                    <img data-tooltip="<?=$player['race_name'] . ' • ' . ($player['gender'] ? 'Female' : 'Male')?>" src="/public/img/icon/race/<?=$player['race'] . '-' . $player['gender']?>.webp"/>
                                </div>
                                <div class="class">
                                    <img data-tooltip="<?=$player['class_name']?>" src="/public/img/icon/class/<?=$player['class']?>.webp"/>
                                </div>
                                <div class="playtime"><?=$player['playtime']?></div>
                            </div>
<? } ?>
<? } else { ?>
                            <div class="row error">
                                <div>There are currently no online players for this realm.</div>
                            </div>
<? } ?>
                        </div>
<? } ?>
                    </div>
                </div>
<? } else { ?>
                <div class="section _404">
                    <div class="header">Players</div>
                    <div class="content">
                        <div class="warning">
                            <p>“I couldn't find any realms in the database.”</p>
                        </div>
                        <div class="orc"></div>
                    </div>
                </div>
<? } ?>
<? include('./application/views/footer.php'); ?>