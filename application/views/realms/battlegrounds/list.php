<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/realms.css">
                <link rel="stylesheet" href="/public/css/_404.css">
<? if (count($realms) > 0) { ?>
                <div class="section">
                    <div class='header'><?=$subtitle?></div>
                    <div class="content">
<? foreach ($realms as $realm) { ?>
                        <div class="subheader">
                            <div>Battleground history for our <div class='name'><?=$realm['name']?></div> realm:</div>
                        </div>
                        <div class="table battlegrounds">
                            <div class="header">
                                <div class="id">#</div>
                                <div class="type">Type</div>
                                <div class="bracket">Bracket</div>
                                <div class="date">Ended</div>
                            </div>
<? if (count($realm['battlegrounds']) > 0) { ?>
<? foreach ($realm['battlegrounds'] as $index => $battleground) { ?>
                            <div class="row<?=' ' . $realm['version'][0]?>">
                                <div class="id"><?=$index+1?></div>
                                <div class="type<?=' ' . lcfirst($battleground['winner'])?>">
                                    <img data-tooltip="<?=$battleground['winner']?>" alt="<?=$battleground['winner']?>" src="/public/img/icon/faction/<?=lcfirst($battleground['winner'])?>.webp"/>
                                    <a href="/realms/battlegrounds/<?=$realm['id']?>-<?=$battleground['id']?>"><?=$battleground['type'] . ' #' . $battleground['id']?></a>
                                </div>
                                <div class="bracket"><?=$battleground['bracket']?></div>
                                <div class="date"><?=date("d-m-y H:i", strtotime($battleground['date']))?></div>
                            </div>
<? } ?>
<? } else { ?>
                            <div class="row error">
                                <div>There are no battleground statistics recorded for this realm.</div>
                            </div>
<? } ?>
                        </div>
<? } ?>
                    </div>
                </div>
<? } else { ?>
                <div class="section _404">
                    <div class="header">Battlegrounds</div>
                    <div class="content">
                        <div class="warning">
                            <p>“I couldn't find any realms in the database.”</p>
                        </div>
                        <div class="orc"></div>
                    </div>
                </div>
<? } ?>
<? include('./application/views/footer.php'); ?>