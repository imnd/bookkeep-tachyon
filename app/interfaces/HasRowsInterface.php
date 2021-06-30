<?php

namespace app\interfaces;

interface HasRowsInterface
{
    public function getRows();

    public function setRows($rows = []);

    public function getQuantitySum();

    public function getPriceSum();
}
