<?php 
if (floor($sum)==$sum)
    $sum .= '.00';

if ($quantity == floor($quantity)) {
    $quantity = (int)($quantity) . '.000';
} elseif ($quantity*10 == floor($quantity * 10)) {
    $quantity = (int)($quantity * 10)/10 . '00';
} elseif ($quantity*100 == floor($quantity * 100)) {
    $quantity = (int)($quantity * 100)/100 . '0';
}
    
?>
<tr class="total">
    <td colspan="3"><b>Итого: </b></td>
    <td><?=$quantity?></td>
    <td></td>
    <td><?=$sum?></td>
    <td colspan="2"></td>
    <td><?=$sum?></td>
    <td colspan="2"></td>
</tr>