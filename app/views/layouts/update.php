@include('head')

    <p>Поля с <span class="error">*</span> обязательны к заполнению.</p>

    <div id="errors" class="row"></div>

    <div class="form">

        @contents

    </div>

@include('foot')
