<? include('./application/views/header.php'); ?>
                <link rel='stylesheet' href='/public/css/realms.css'>
                <script type='text/javascript' src='/public/js/viewer.min.js'></script>
                <script type='text/javascript' src='/public/js/viewer.config.js'></script>
                <script type='text/javascript' src='/public/js/wowhead_tooltip.js'></script>
                <div class='section armory'>
                    <div class='header'><?=$subtitle?></div>
                    <div class='content'>
                        <div class='header <?=lcfirst($character['faction'])?>'>
                            <div class='information'>
<? if (REALMS_ARMORY_ENABLED) { ?>
                                <a class='name <?=lcfirst($character['class_name'])?>' href='/realms/armory/<?=$realm['id'] . '-' . $character['id']?>'><?=$character['name']?></a>
<? } else { ?>
                                <?=$character['name']?>
<? } ?>
                                <div class='level'>Level <?=$character['level']?>, <?=$character['race_name'] . ' ' . $character['class_name']?></div>
<? if ($character['guild_id'] !== null) { ?>
                                <div class='guild'>
                                    <?=$character['guild_rank']?> of <a href='/realms/guilds/<?=$realm['id'] . '-' . $character['guild_id']?>'><?=$character['guild_name']?></a>
                                </div>
<? } ?>
                            </div>
                        </div>
                        <div class='body'>
                            <div id='viewer' class='<?=str_replace(' ', '_', strtolower($character['race_name']))?>'>
                                <div class='resistance fire' data-tooltip='Fire Resistance: <?=$character['fire_resistance']?>'><?=$character['fire_resistance']?></div>
                                <div class='resistance nature' data-tooltip='Nature Resistance: <?=$character['nature_resistance']?>'><?=$character['nature_resistance']?></div>
                                <div class='resistance frost' data-tooltip='Frost Resistance: <?=$character['frost_resistance']?>'><?=$character['frost_resistance']?></div>
                                <div class='resistance shadow' data-tooltip='Shadow Resistance: <?=$character['shadow_resistance']?>'><?=$character['shadow_resistance']?></div>
                                <div class='resistance arcane' data-tooltip='Arcane Resistance: <?=$character['arcane_resistance']?>'><?=$character['arcane_resistance']?></div>
                                <div class='powers'>
                                    <div class='health' data-tooltip='Health: <?=$character['health']?>'>Health: <?=$character['health']?></div>
<? if ($character['mana'] > 0) { ?>
                                    <div class='mana' data-tooltip='Mana: <?=$character['mana']?>'>Mana: <?=$character['mana']?></div>
<? } ?>
                                </div>
                                <div class='spinner'></div>
<? foreach($slots as $slot => $type) { ?>
                                <div class='slot <?=$type?>'>
<? if ($character['items'][$slot]) { ?>
                                    <a class='<?=lcfirst($character['items'][$slot]['quality_name'])?>' href='#' onClick='return false' data-wowhead='item=<?=$character['items'][$slot]['id']?>&domain=<?=$realm['version'][0]?>&rand=<?=$character['items'][$slot]['random_property']?>'>
                                        <img src='/public/img/icon/36x36/<?=$character['items'][$slot]['icon']?>.webp'/>
                                    </a>
<? } ?>
                                </div>
<? } ?>
                            </div>
                            <div class='details'>
                                <div class='category'>
                                    <div class='subheader'>Base Statistics</div>
                                    <div class='row'>
                                        <span>Strength</span>
                                        <span><?=$character['strength']?></span>
                                    </div>
                                    <div class='row'>
                                        <span>Agility</span>
                                        <span><?=$character['agility']?></span>
                                    </div>
                                    <div class='row'>
                                        <span>Stamina</span>
                                        <span><?=$character['stamina']?></span>
                                    </div>
                                    <div class='row'>
                                        <span>Intellect</span>
                                        <span><?=$character['intellect']?></span>
                                    </div>
                                    <div class='row'>
                                        <span>Spirit</span>
                                        <span><?=$character['spirit']?></span>
                                    </div>
                                    <div class='row'>
                                        <span>Armor</span>
                                        <span><?=$character['armor']?></span>
                                    </div>
                                </div>
                                <div class='category'>
                                    <div class='subheader'>Extra Statistics</div>
                                    <div class='row'>
                                        <span>Block Chance</span>
                                        <span><?=round($character['block_chance'], 2)?>%</span>
                                    </div>
                                    <div class='row'>
                                        <span>Dodge Chance</span>
                                        <span><?=round($character['dodge_chance'], 2)?>%</span>
                                    </div>
                                    <div class='row'>
                                        <span>Parry Chance</span>
                                        <span><?=round($character['parry_chance'], 2)?>%</span>
                                    </div>
                                    <div class='row'>
                                        <span>Crit Chance</span>
                                        <span><?=round($character['crit_chance'], 2)?>%</span>
                                    </div>
                                    <div class='row'>
                                        <span>Ranged Chance</span>
                                        <span><?=round($character['ranged_crit_chance'], 2)?>%</span>
                                    </div>
                                    <div class='row'>
                                        <span>Attack Power</span>
                                        <span><?=$character['attack_power']?></span>
                                    </div>
                                    <div class='row'>
                                        <span>Ranged/Spell Power</span>
                                        <span><?=$character['ranged_attack_power']?></span>
                                    </div>
                                </div>
<? if (count($character['professions']) > 0) { ?>
                                <div class='category'>
                                    <div class='subheader'>Professions</div>
<? foreach ($character['professions'] as $profession) { ?>
                                    <div class='row'>
                                        <span><?=$profession['name']?></span>
                                        <span><?=$profession['value'] . ' / ' . $profession['max']?></span>
                                    </div>
<? } ?>
                                </div>
<? } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <script type='module'>
                    const whTooltips = { colorLinks: false, iconizeLinks: false, renameLinks: false };
                    const viewer = await generateViewer(315/441, `#viewer`, {
                        'race': <?=$character['race']?>,
                        'gender': <?=$character['gender']?>,
                        'skin': <?=$character['skin']?>,
                        'face': <?=$character['face']?>,
                        'hairStyle': <?=$character['hair_style']?>,
                        'hairColor': <?=$character['hair_color']?>,
                        'facialStyle': <?=$character['facial_hair']?>,
                        'items': [<?=$character['models']?>],
                        'noCharCustomization': false
                    }, {
                        distance: <?=$character['position'][0]?>,
                        azimuth: 0.25,
                        translate: { x: <?=$character['position'][1]?>, y: <?=$character['position'][2]?>, z: <?=$character['position'][3]?> }
                    });
                    let sheathed = false;
                    viewer.setViewerLoadedCallback(() => setTimeout(() => {
                        $('.main_hand').trigger('click');
                        setTimeout(() => {
                            $('.spinner').hide();
                            $('#viewer>canvas').css('opacity', '1');
                        }, 25);
                    }, 975));
                    $('.main_hand, .off_hand').on('click', () => {
                        viewer.setAnimationPaused(false);
                        viewer.setSheath(sheathed ? -1 : <?=$character['sheath'][0]?>, sheathed ? -1 : <?=$character['sheath'][1]?>);
                        sheathed = !sheathed;
                        setTimeout(() => viewer.setAnimationPaused(true), 25);
                    });
                </script>
<? include('./application/views/footer.php'); ?>