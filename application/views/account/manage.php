<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/account.css">
                <div class="section manage">
                    <div class="header"><?=$subtitle?></div>
                    <div class="content">
                        <div class="subheader">Your account information:</div>
                        <div class="details">
                            <div class="tags">
                                <div>Nickname</div>
                                <div>Username</div>
                                <div>Email</div>
                                <div>IP</div>
                                <div>Platform</div>
                                <div>Client</div>
                            </div>
                            <div class="data">
                                <div><?=$information['nickname']?></div>
                                <div><?=$information['username']?></div>
                                <div><?=$information['email']?></div>
                                <div><?=$information['ip']?></div>
                                <div><?=$information['platform']?></div>
                                <div><?=$information['client']?></div>
                            </div>
                            <div class="media">
                                <div onclick="location = '/account/avatar'" data-tooltip="Change Avatar (<?=ucwords(str_replace('_', ' ', $information['avatar']))?>)" class="avatar<?=$information['gmlevel'] > 0 ? ' admin' : ''?>" style="--image: url('/public/img/avatar/<?=$information['avatar']?>.webp')"></div>
                                <div onclick="location = '/account/signature'" data-tooltip="Change Signature (<?=ucwords(str_replace('_', ' ', $information['signature']))?>)" class="signature" style="--image: url('/public/img/signature/<?=$information['signature']?>.webp')"></div>
                            </div>
                        </div>
                        <div class="actions">
                            <a href="/account/nickname">Change Nickname</a>
                            <a href="/account/password">Change Password</a>
                            <a href="/account/email">Change Email</a>
                            <a href="/account/mfa"><?=$information['mfa'] ? 'Disable' : 'Enable'?> MFA</a>
                            <a href="/account/logs">Access Logs</a>
                        </div>
<? if (count($realms) > 0) { ?>
<? foreach ($realms as $realm) { ?>
                        <div class="subheader">
                            <div>Your characters on our <div class='name'><?=$realm['name']?></div> realm:</div>
                        </div>
                        <div class="table characters<?=' ' . $realm['version'][0]?>">
                            <div class="header">
                                <div class="id">#</div>
                                <div class="name">Name</div>
                                <div class="level">Level</div>
                                <div class="race">Race</div>
                                <div class="class">Class</div>
                                <div class="money">Money</div>
                                <div class="playtime">Playtime</div>
                            </div>
<? if (count($realm['characters']) > 0) { ?>
<? foreach ($realm['characters'] as $index => $character) { ?>
                            <div class="row<?=' ' . lcfirst($character['faction'])?>">
                                <div class="id"><?=$index+1?></div>
                                <div class="name">
<? if (REALMS_ARMORY_ENABLED) { ?>
                                    <a href="/realms/armory/<?=$realm['id'] . '-' . $character['id']?>"><?=$character['name']?></a>
<? } else { ?>
                                    <?=$character['name']?>
<? } ?>
                                </div>
                                <div class="level"><?=$character['level']?></div>
                                <div class="race"><img data-tooltip="<?=$character['race_name'] . ' • ' . ($character['gender'] ? 'Female' : 'Male')?>" src="/public/img/icon/race/<?=$character['race'] . '-' . $character['gender']?>.webp"/></div>
                                <div class="class"><img data-tooltip="<?=$character['class_name']?>" src="/public/img/icon/class/<?=$character['class']?>.webp"/></div>
                                <div class="money">
                                    <img data-tooltip="Gold" src="/public/img/icon/currency/gold.webp"/><?=$character['money']['gold']?>
                                    <img data-tooltip="Silver" src="/public/img/icon/currency/silver.webp"/><?=$character['money']['silver']?>
                                    <img data-tooltip="Copper" src="/public/img/icon/currency/copper.webp"/><?=$character['money']['copper']?>
                                </div>
                                <div class="playtime"><?=$character['playtime']?></div>
                            </div>
<? } } else { ?>
                            <div class="row error">
                                <div>You currently have no characters on this realm.</div>
                            </div>
<? } ?>
                        </div>
<? } } ?>
                    </div>
                </div>
<? include('./application/views/footer.php'); ?>