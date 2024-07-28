<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/account.css">
                <div class="section success">
                    <div class="header"><?=$subtitle?></div>
                    <div class="content">
                        <div class="info">
                            <p>“You've disabled MFA for your account, <font color='#F00'><?=$username;?></font>!”</p>
                            <p>“No idea why you'd ever want to do that, but suit yourself...”</p>
                        </div>
                        <div class="orc"></div>
                    </div>
                </div>
<? include('./application/views/footer.php'); ?>