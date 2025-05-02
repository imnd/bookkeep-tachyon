<form method="POST" action="<?= request()->getRoute() ?>">
    <div class="row">
        <?php
        $this->display(
            '../blocks/input',
            [
                'entity' => $entity,
                'name' => 'contract_num',
            ]
        ) ?>
    </div>
    <div class="row">
        <?php
        $this->display(
            '../blocks/select',
            [
                'entity' => $entity,
                'name' => 'client_id',
                'options' => $clients,
            ]
        ) ?>
    </div>
    <div class="row">
        <?php
        $this->display(
            '../blocks/input',
            [
                'entity' => $entity,
                'name' => 'date',
                'type' => 'date',
            ]
        ) ?>
    </div>
    <div class="row">
        <?php
        $this->display(
            '../blocks/input',
            [
                'entity' => $entity,
                'name' => 'sum',
            ]
        ) ?>
    </div>
    <div class="row">
        <?php
        $this->display(
            '../blocks/input',
            [
                'entity' => $entity,
                'name' => 'remainder',
            ]
        ) ?>
    </div>
    <div class="row">
        <?php
        $this->display(
            '../blocks/select',
            [
                'entity' => $entity,
                'name' => 'contents',
                'options' => $contents,
            ]
        ) ?>
    </div>

    <input type="submit" class="button" value="<?= t('save') ?>">
    <div class="clear"></div>
</form>
