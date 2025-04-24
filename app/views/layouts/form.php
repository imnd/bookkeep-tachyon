<?php use tachyon\components\Flash;?>

@extends('main')

<p>Поля с <span class="error">*</span> обязательны к заполнению.</p>

<div class="error row"><?=flash(Flash::FLASH_TYPE_ERROR)?></div>

<div class="form">

    @contents

</div>
