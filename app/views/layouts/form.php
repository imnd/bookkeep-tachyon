@extends('main')

<p>Поля с <span class="error">*</span> обязательны к заполнению.</p>

<div class="error row"><?=$this->flash->getFlash(\tachyon\components\Flash::FLASH_TYPE_ERROR)?></div>

<div class="form">

    @contents

</div>
