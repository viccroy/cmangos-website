<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/account.css">
                <div class="section password">
                    <div class="header"><?=$subtitle?></div>
                    <form method='post'>
                        <div class="input<?=strlen($errors['password']) ? " error" : ""?>">
                            <div class="element">
                                <label for="password">Current Password</label>
                                <input type='password' id="password" name='password' maxlength='16' value='<?=$values['password']?>' autocorrect='off' autocapitalize='off'>
                            </div>
                            <div class="info">Between 4-16 alphanumeric characters.<br/>Allowed characters: . ! @ # $ % ^ & * _ - +</div>
                            <div class="warning"><?=$errors['password']?></div>
                        </div>
                        
                        <div class="input<?=strlen($errors['password_new']) ? " error" : ""?>">
                            <div class="element">
                                <label for="password_new">New Password</label>
                                <input type='password' id="password_new" name='password_new' maxlength='16' value='<?=$values['password_new']?>' autocorrect='off' autocapitalize='off'>
                            </div>
                            <div class="info">Between 4-16 alphanumeric characters.<br/>Allowed characters: . ! @ # $ % ^ & * _ - +</div>
                            <div class="warning"><?=$errors['password_new']?></div>
                        </div>
                        
                        <div class="input<?=strlen($errors['password_new_confirm']) ? " error" : ""?>">
                            <div class="element">
                                <label for="password_new_confirm">Confirm New Password</label>
                                <input type='password' id="password_new_confirm" name='password_new_confirm' maxlength='16' value='<?=$values['password_new_confirm']?>' autocorrect='off' autocapitalize='off'>
                            </div>
                            <div class="info">Between 4-16 alphanumeric characters.<br/>Allowed characters: . ! @ # $ % ^ & * _ - +</div>
                            <div class="warning"><?=$errors['password_new_confirm']?></div>
                        </div>
<? if ($errors['mfa']) { ?>
                        <div class="input<?=strlen($errors['code']) ? " error" : ""?>">
                            <div class="element">
                                <label for="code">OTP / RECOVERY KEY</label>
                                <input type='text' id="code" name='code' maxlength='<?=OTP_TOKEN_LENGTH?>' value='' autocorrect='off' autocapitalize='off' autofocus>
                            </div>
                            <div class="info">Exactly <?=OTP_TOKEN_LENGTH?> numeric / alphanumeric characters.</div>
                            <div class="warning"><?=$errors['code']?></div>
                        </div>
<? } ?>
                        <div class="input">
                            <div class="button">
                                <input type='submit' value='Change'/>
                            </div>
                        </div>
                    </form>
                </div>
<? include('./application/views/footer.php'); ?>