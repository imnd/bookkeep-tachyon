<h4>Регистрация</h4>
<form method="post">
    <div class="row">
        <input name="username" placeholder="логин"/>
    </div>
    <div class="row">
        <input name="email" placeholder="email"/>
    </div>
    <div class="row">
        <input name="password" placeholder="пароль" type="password" />
    </div>
    <div class="row">
        <input name="password_confirm" placeholder="подтверждение пароля" type="password" />
    </div>
    <?php $this->display('_error', compact('error'))?>
    <input type="submit" value="зарегаться"/>
</form>
