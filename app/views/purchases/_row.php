<?php /** @var \tachyon\View $this */ ?>
<tr class="row">
    <?=$this->html->hidden(array(
        'name' => "article[$i]",
        'value' => $item->article_subcat_id,
    ))?>
    <td class="article"><?=$item->article_subcat?></td>
    <td class="quantity" id="quantity_<?=$i?>"><?=$this->html->hidden(array(
        'name' => "quantity[$i]",
        'value' => $item->quantity,
    ))?><?=$item->quantity?></td>
    <td class="price"><?=$this->html->input("price[$i]")?></td>
    <td class="sum" id="summ_<?=$i?>"><?=$this->html->input(array(
        'name' => 'sum',
    ))?></td>
</tr>