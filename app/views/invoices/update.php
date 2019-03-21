<?php
$subMenu = [
    "delete/$pk",
    "view/$pk",
    [
        'action' => "printout/type/bill/$pk",
        'title' => 'распечатать фактуру',
    ],
    [
        'action' => "printout/type/invoice/$pk",
        'title' => 'распечатать накладную',
    ],
];
$this->display('_form', compact('model'));
