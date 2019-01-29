@include('head')

    <p>Поля с <span class="error">*</span> обязательны к заполнению.</p>

    <div id="errors" class="row"></div>
    <?=$this->controller->getMessage()?>

    <div class="form">

        @contents

    </div>

@include('foot')
