<tr class="row">
    <td class="article">
        <?=$this->html->selectEx($row, array(
            'options' => $articles,
            'name' => 'article_id',
            'multiple' =>true,
        ))?>
    </td>
    <td>кг</td>
    <td class="quantity">
        <?=$this->html->inputEx($row, array(
            'name' => 'quantity',
            'multiple' =>true,
         ))?>
    </td>
    <td class="price">
        <?=$this->html->inputEx($row, array(
            'name' => 'price',
            'multiple' =>true,
        ))?>
    </td>
    <td class="sum">
        <?=$this->html->inputEx($row, array(
            'name' => 'sum',
            'multiple' =>true,
            'readonly' => 'readonly',
        ))?>
    </td>
    <td class="delete-btn"><?=$this->html->button()?></td>
</tr>