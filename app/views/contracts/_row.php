<tr class="row">
    <td class="article">
        <?php $this->display('../blocks/select', [
            'label' => false,
            'entity' => $row,
            'name' => 'articleId[]',
            'options' => $articlesList,
        ])?>
    </td>
    <td>кг</td>
    <td class="quantity">
        <?php $this->display('../blocks/input', [
            'label' => false,
            'entity' => $row,
            'name' => 'quantity[]',
        ])?>
    </td>
    <td class="price">
        <?php $this->display('../blocks/input', [
            'label' => false,
            'entity' => $row,
            'name' => 'price[]',
        ])?>
    </td>
    <td class="sum">
        <?php $this->display('../blocks/input', [
            'label' => false,
            'entity' => $row,
            'name' => 'row_sum[]',
            'readonly' => 'readonly',
        ])?>
    </td>
    <td class="delete-btn"><?=$this->html->button()?></td>
</tr>