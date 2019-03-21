@extends('main')

<p>Поля с <span class="error">*</span> обязательны к заполнению.</p>

<div class="error row"><?=$this->flash->getFlash()?></div>

<div class="form">

    @contents

</div>
