<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/account.css">
                <div class="section recover">
                    <div class="header"><?=$subtitle?></div>
                    <div class="content">
                        <div class="info">
                            <p>“Congratulations! You've reset your account password, <font color='#F00'><?=$username;?></font>!”</p>
                            <p>“You should probably proceed to the <a href="/account/login">login</a> page.”</p>
                        </div>
                        <div class="orc"></div>
                    </div>
                </div>
<? include('./application/views/footer.php'); ?>