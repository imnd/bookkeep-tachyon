<?php
$this->controller->setSubMenu(array(
    "delete/$pk",
    "view/$pk",
    array(
        'action' => "printout/type/bill/$pk",
        'title' => 'распечатать фактуру',
    ),
    array(
        'action' => "printout/type/invoice/$pk",
        'title' => 'распечатать накладную',
    ),
));
$this->display('_form', compact('model'));
