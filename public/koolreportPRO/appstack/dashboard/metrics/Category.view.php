<?php 
    use \koolreport\dashboard\Lang; 
    $total = $this->data()->sum($this->measuredField()->colName());
?>
<div id="<?php echo $this->master()->name(); ?>" class="card card-accent-<?php echo $this->master()->type(); ?> card-value">
    <div class="card-body pb-0" style="min-height:142px">
        <div class="row">
            <div class="col">
                <div class="text-muted text-uppercase font-weight-bold font-xs"><?php echo $this->master()->title(); ?></div>    
            </div>
            <div class="col text-right">
                <div class="h5 text-secondary"><?php echo $this->measuredField()->field()->formatValue($total); ?></div>
            </div>
        </div>
        <div>
        <div style="display:inline-block;float:right;position:relative;top:-5px;left:10px;">
        <?php
            \koolreport\d3\DonutChart::create([
                "dataSource"=>$this->donutData(),
                "colorScheme"=>$this->colors(),
                "height"=>$this->master()->pieSize(),
                "width"=>$this->master()->pieSize(),
                "options"=>[
                    "legend"=>[
                        "show"=>false,
                    ],
                    "tooltip"=>[
                        "format"=>[
                            "title"=>"function(){
                                return '".$this->master()->title()."';
                            }",
                        ]
                    ],
                    "donut"=>[
                        "label"=>[
                            "show"=>false
                        ]
                    ]
                ]
            ]);
        ?>

        </div>
        <small>
            <ul class="list-inline">
                <?php foreach($this->data() as $i=>$row): ?>
                    <li>
                        <i class="fa fa-circle" style="color:<?php echo $this->colors()[$i]; ?>"></i> 
                        <?php 
                            $field = $this->categoryField()->field(); 
                            echo $field->row($row)->formattedValue();
                        ?>
                        -
                        <?php
                            echo $this->measuredField()->formatValue(
                                ($this->measuredField()->_showRawValue()===true)?
                                    $row[$this->measuredField()->colName()]:
                                    $row[$this->measuredField()->colName()]*100/$total,
                            $row);
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </small>

        <div class="row">
            <div class="col-8">
            </div>
            <div class="col-4 text-right">
            </div>
        </div>
        </div>
    </div>
</div>