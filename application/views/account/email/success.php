<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/account.css">
                <div class="section email">
                    <div class="header"><?=$subtitle?></div>
                    <div class="content">
                    <div class="info">
                            <p>“You've successfully changed your email, <font color='#F00'><?=$username;?></font>!”</p>
                            <p>“You should probably proceed to the <a href="/account/<?=$authenticated ? 'manage' : 'login'?>"><?=$authenticated ? 'manage' : 'login'?></a> page.”</p>
                        </div>
                        <div class="orc"></div>
                    </div>
                </div>
<? include('./application/views/footer.php'); ?>