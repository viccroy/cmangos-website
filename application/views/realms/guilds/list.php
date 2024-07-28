<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/realms.css">
                <link rel="stylesheet" href="/public/css/_404.css">
<? if (count($realms) > 0) { ?>
                <div class="section">
                    <div class='header'><?=$subtitle?></div>
                    <div class="content">
<? foreach ($realms as $realm) { ?>
                        <div class="subheader">
                            <div>Guilds on our <div class='name'><?=$realm['name']?></div> realm:</div>
                        </div>
                        <div class="table guilds">
                            <div class="header">
                                <div class="id">#</div>
                                <div class="name">Name</div>
                                <div class="members">Members</div>
                                <div class="leader">Leader</div>
                                <div class="date">Created</div>
                            </div>
<? if (count($realm['guilds']) > 0) { ?>
<? foreach ($realm['guilds'] as $index => $guild) { ?>
                            <div class="row<?=' ' . $realm['version'][0]?>">
                                <div class="id"><?=$index+1?></div>
                                <div class="name<?=' ' . lcfirst($guild['faction'])?>">
                                    <a href="/realms/guilds/<?=$realm['id']?>-<?=$guild['id']?>"><?=$guild['name']?></a>
                                </div>
                                <div class="members"><?=$guild['members']?></div>
                                <div class="leader<?=' ' . lcfirst($guild['faction'])?>">
<? if (REALMS_ARMORY_ENABLED) { ?>
                                    <a href="/realms/armory/<?=$realm['id'] . '-' . $guild['leader_id']?>"><?=$guild['leader_name']?></a>
<? } else { ?>
                                    <?=$guild['leader_name']?>
<? } ?>  
                                </div>
                                <div class="date"><?=date("d-m-y H:i", strtotime($guild['date']))?></div>
                            </div>
<? } ?>
<? } else { ?>
                            <div class="row error">
                                <div>There are no guilds on this realm.</div>
                            </div>
<? } ?>
                        </div>
<? } ?>
                    </div>
                </div>
<? } else { ?>
                <div class="section _404">
                    <div class="header">Guilds</div>
                    <div class="content">
                        <div class="warning">
                            <p>“I couldn't find any realms in the database.”</p>
                        </div>
                        <div class="orc"></div>
                    </div>
                </div>
<? } ?>
<? include('./application/views/footer.php'); ?>