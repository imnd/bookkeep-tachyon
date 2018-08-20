<div>
    <?php foreach ($requisites[$type] as $key => $requisite) {?>
    <div class="row">
        <?=
        $this->html->label($requisite['name']),
        $this->html->input(array(
            'name' => "{$type}_$key",
            'value' => $requisite['value']
        ))
        ?>
    </div>
    <?php }?>
</div>