<? include('./application/views/header.php'); ?>
                <link rel="stylesheet" href="/public/css/account.css">
                <div class="section email">
                    <div class="header"><?=$subtitle?></div>
                    <div class="content">
                    <div class="info">
                            <p>“You're almost finished changing your email, <font color='#F00'><?=$username;?></font>!”</p>
                            <p>“There's just <?=!$step ? 'two more tiny steps.' : 'one more tiny step.'?>”</p>
                            <p>“I've sent a message to your <?=!$step ? 'current' : 'new' ?> email with instructions.”</p>
                        </div>
                        <div class="orc"></div>
                    </div>
                </div>
<? include('./application/views/footer.php'); ?>