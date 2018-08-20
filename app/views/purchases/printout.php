<?php
$this->pageTitle = "Печать товарной накладной №{$item->number}";
$this->display('../blocks/torg-12', compact('item', 'contractType', 'quantitySum', 'sender', 'client'));
