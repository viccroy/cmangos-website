<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/account.css">
                <div class="section success">
                    <div class="header"><?=$subtitle?></div>
                    <div class="content">
                        <div class="info">
                            <p>“You've enabled MFA for your account, <font color='#F00'><?=$username;?></font>!”</p>
                            <p>“Here's a list of recovery codes, if you lose your device!”</p>
                            <p><?=implode(', ', $recovery_tokens)?></p>
                        </div>
                        <div class="orc"></div>
                    </div>
                </div>
<? include('./application/views/footer.php'); ?>