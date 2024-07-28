<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/realms.css">
                <link rel="stylesheet" href="/public/css/_404.css">
                <div class="section">
                    <div class='header'><?=$subtitle?></div>
                    <div class="content">
                        <div class="subheader">
                            <div>
                                <div class='name'><?=$guild['name']?></div> was created by <div class='name'><?=$guild['leader_name']?></div> on <div class='time'><?=date("d-m-y H:i", strtotime($guild['date']))?></div>!
                            </div>
                        </div>
                        <div class="table guild_details">
                            <div class="header">
                                <div class="id">#</div>
                                <div class="name">Name</div>
                                <div class="level">Level</div>
                                <div class="race">Race</div>
                                <div class="class">Class</div>
                                <div class="rank">Rank</div>
                            </div>
<? if (count($players) > 0) { ?>
    <? foreach ($players as $index => $player) { ?>
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
                                <div class="rank"><?=$player['rank']?></div>
                            </div>
<? } ?>
<? } else { ?>
                            <div class="row error">
                                <div>There are no player statistics recorded for this battleground.</div>
                            </div>
<? } ?>
                        </div>
                    </div>
                </div>
<? include('./application/views/footer.php'); ?>