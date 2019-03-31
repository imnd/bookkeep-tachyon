<?php /** @var \tachyon\View $this */ ?>
<tr class="row">
    <?=$this->html->hidden([
        'name' => "article[$i]",
        'value' => $item->article_subcat_id,
    ])?>
    <td class="article"><?=$item->article_subcat?></td>
    <td class="quantity"><?=$this->html->hidden(array(
        'name' => "quantity[$i]",
        'value' => $item->quantity,
    ))?><?=$item->quantity?></td>
    <td class="price"><?=$this->html->input("price[$i]")?></td>
    <td class="sum"><?=$this->html->input([
        'name' => 'sum',
    ])?></td>
</tr>