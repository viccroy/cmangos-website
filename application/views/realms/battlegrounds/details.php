<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/realms.css">
                <link rel="stylesheet" href="/public/css/_404.css">
                <div class="section">
                    <div class='header'><?=$subtitle?></div>
                    <div class="content">
                        <div class="subheader">
                            <div>
                                <?='' . $battleground['bracket'] . ' • '?><div class='name'><?=$battleground['type'] . ' #' . $battleground['id']?></div> on <div class='name'><?=$realm['name']?></div><?=lcfirst($battleground['winner']) === 'draw' ? ' ended in a ' : ' ended with ' ?><div class='result<?=' ' . lcfirst($battleground['winner'])?>'><?=$battleground['winner']?></div><?=lcfirst($battleground['winner']) !== 'draw' ? ' winning' : ''?> on <div class='time'><?=date("d-m-y H:i", strtotime($battleground['date']))?></div>!
                            </div>
                        </div>
                        <div class="table battleground_details">
                            <div class="header">
                                <div class="id">#</div>
                                <div class="name">Name</div>
                                <div class="race">Race</div>
                                <div class="class">Class</div>
                                <div class="kdhk">K / D / HK</div>
                                <div class="honor">Honor</div>
                                <div class="damage-healing">Damage / Healing</div>
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
                                
                                <div class="race">
                                    <img data-tooltip="<?=$player['race_name'] . ' • ' . ($player['gender'] ? 'Female' : 'Male')?>" src="/public/img/icon/race/<?=$player['race'] . '-' . $player['gender']?>.webp"/>
                                </div>
                                <div class="class">
                                    <img data-tooltip="<?=$player['class_name']?>" src="/public/img/icon/class/<?=$player['class']?>.webp"/>
                                </div>
                                <div class="kdhk"><?=$player['kills']?> / <?=$player['deaths']?> / <?=$player['honorable_kills']?></div>
                                <div class="honor"><?=$player['honor']?></div>
                                <div class="damage-healing">
                                    <div>
                                        <div><?=$player['damage']?></div> / <div><?=$player['healing']?></div>
                                    </div>
                                </div>
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