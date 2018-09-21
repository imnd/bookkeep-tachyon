<h4>Авторизация</h4>
<form method="post">
    <div class="row">
        <input name="username" placeholder="логин"/>
    </div>
    <div class="row">
        <input name="password" placeholder="пароль" type="password" />
    </div>
    <div class="row">
        <input name="remember" type="checkbox" checked="checked" value="1" />&nbsp;<label>запомнить</label>
    </div>
    <?php $this->display('_error', compact('error'))?>
    <input type="submit" value="войти"/>&nbsp;&nbsp;<a class="" href="/index/register">регистрация</a>
</form>