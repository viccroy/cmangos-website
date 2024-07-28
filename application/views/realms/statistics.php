<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/realms.css">
                <link rel="stylesheet" href="/public/css/_404.css">
<? if (count($realms) > 0) { ?>
                <div class="section">
                    <div class='header'><?=$subtitle?></div>
                    <div class="content">
<? foreach ($realms as $realm) { ?>
                        <div class="subheader">
                            <div>Race and Class statistics for our <div class='name'><?=$realm['name']?></div> realm:</div>
                        </div>
                        <div class="graph races">
                            <div class="data <?=$realm['version'][0]?>">
<? foreach ($realm['statistics']['available_races'] as $race) { ?>
<? $bar_height = 0; ?>
<? if($realm['statistics']['races'][$race]['count'] !== 0 && $realm['statistics']['races'][$race]['total'] !== 0) { ?>
<? $bar_height = 148*$realm['statistics']['races'][$race]['count']/$realm['statistics']['races'][$race]['total']; ?>
<? } ?>
                                <div class="bar" data-tooltip="<?=$realm['statistics']['races'][$race]['count'] . ' / ' . $realm['statistics']['races'][$race]['total'] . ' • ' . $realm['statistics']['races'][$race]['percentage'] . '%'?>">
                                    <div class="fill" style="height: <?=$bar_height?>px"></div>
                                </div>
<? } ?>
                            </div>
                            <div class="legend">
<? foreach ($realm['statistics']['available_races'] as $race) { ?>
                                <div class="race">
                                    <img data-tooltip="<?=$realm['statistics']['races'][$race]['name']?>" src="/public/img/icon/race/<?=$race?>.webp"/>
                                </div>
<? } ?>
                            </div>
                        </div>
                        <div class="graph classes">
                            <div class="data <?=$realm['version'][0]?>">
<? foreach ($realm['statistics']['available_classes'] as $class) { ?>
<? $bar_height = 0; ?>
<? if($realm['statistics']['classes'][$class]['count'] !== 0 && $realm['statistics']['classes'][$class]['total'] !== 0) { ?>
<? $bar_height = 148*$realm['statistics']['classes'][$class]['count']/$realm['statistics']['classes'][$class]['total']; ?>
<? } ?>
                                <div class="bar" data-tooltip="<?=$realm['statistics']['classes'][$class]['count'] . ' / ' . $realm['statistics']['classes'][$class]['total'] . ' • ' . $realm['statistics']['classes'][$class]['percentage'] . '%'?>">
                                    <div class="fill" style="height: <?=$bar_height?>px"></div>
                                </div>
<? } ?>
                            </div>
                            <div class="legend">
<? foreach ($realm['statistics']['available_classes'] as $class) { ?>
                                <div class="race">
                                    <img data-tooltip="<?=$realm['statistics']['classes'][$class]['name']?>" src="/public/img/icon/class/<?=$class?>.webp"/>
                                </div>
<? } ?>
                            </div>
                        </div>
<? } ?>
                    </div>
                </div>
<? } else { ?>
                <div class="section _404">
                    <div class="header">Statistics</div>
                    <div class="content">
                        <div class="warning">
                            <p>“I couldn't find any realms in the database.”</p>
                        </div>
                        <div class="orc"></div>
                    </div>
                </div>
<? } ?>
<? include('./application/views/footer.php'); ?>