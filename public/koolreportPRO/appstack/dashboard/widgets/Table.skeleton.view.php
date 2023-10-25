<?php
$tableClass = "table";
if($this->table()->_tableOutline()===true) {
    $tableClass.=" table-outline";
}

if($this->table()->_tableSmall()===true) {
    $tableClass.=" table-sm";
}
$theadClass = "";
if($this->table()->_headerDark()===true) {
    $theadClass.="thead-light";
}
?>
<?php if($this->table()->_searchable()===true):?>
    <div class="text-<?php echo $this->table()->_searchAlign(); ?>">
        <div class="loading" style="display:inline-block;width:180px;height:2rem;"></div>
    </div>
<?php endif ?>
<table class="<?php echo $tableClass;?>">
    <thead class="<?php echo $theadClass; ?>">
        <tr>
            <?php foreach($this->fields() as $field): ?>
                <th><?php echo $field->label(); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php for($i=0;$i<3;$i++): ?>
            <tr>
                <?php foreach($this->fields() as $field): ?>
                    <td>
                        <div class="loading" style="height:2rem"></div>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endfor ?>
    </tbody>
</table>
<?php if($this->table()->_pageSize()!==null):?>
    <div class="text-<?php echo $this->table()->_pageAlign(); ?>">
        <div class="loading" style="display:inline-block;width:40%;height:2rem;"></div>
    </div>
<?php endif ?>