<?php 
    use \koolreport\dashboard\Lang; 
    $colorList = [
        "info"=>"#1f9bcf",
        "primary"=>"#3f80ea",
        "danger"=>"#d9534f",
        "success"=>"#4bbf73",
        "warning"=>"#e5a54b",
        "secondary"=>"#495057",
        null=>"#c7cbd5"
    ];
?>
<div id="<?php echo $this->master()->name(); ?>" class="card card-accent-<?php echo $this->master()->type(); ?> card-value">
    <div class="card-body pb-1 pl-0 pr-0">
        <div style="margin-left:20px;margin-right:20px;">
            <div class="row">
                <div class="col">
                    <div class="text-muted text-uppercase font-weight-bold font-xs"><?php echo $this->master()->title(); ?></div>
                </div>
                <div class="col">
                    <select <?php echo $this->disableRangeSelect()?"disabled":"";?> onChange="widgetAction('<?php echo $this->master()->name(); ?>','rangeSelect',{selectedRange:$(this).val()});<?php echo $this->master()->showLoaderOnAction()?"showLoader(true);":""; ?>" class="form-control form-control-sm float-right" style="width:auto;">
                        <?php foreach($this->rangeKeys() as $key ): ?>
                            <option value="<?php echo $key; ?>" <?php echo ($this->master()->getSelectedRangeKey()===$key)?"selected":""; ?>><?php Lang::echo($key); ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="mb-0 h3 text-<?php echo $this->master()->type(); ?>"><?php echo $this->currentValue(); ?></div>
        </div>
        <?php
            \koolreport\d3\SplineChart::create([
                "name"=>$this->master()->name()."_chart",
                "dataSource"=>$this->trendData(),
                "columns"=>[
                    "time"=>[
                        "formatValue"=>function($value) {
                            return $this->timeGroup()->formatValue($value);
                        }
                    ],
                    "measure"=>[
                        "label"=>$this->measureField()->label(),
                        "formatValue"=>function($value) {
                            return $this->measureField()->formatValue($value);
                        }
                    ]
                ],
                "colorScheme"=>[$colorList[$this->master()->type()]],
                "height"=>60,
                "options"=>[
                    "tooltip"=>[
                        "format"=>[
                            "title"=>"function(x,index){
                                return ".$this->master()->name()."_chart.settings.fv['time'][index];
                            }"
                        ]
                    ],
                    "point"=>[
                        "r"=>3
                    ],
                    "padding"=>[
                        "left"=>0,
                        "right"=>0
                    ],
                    "axis"=>[
                        "x"=>[
                            "show"=>false
                        ],
                        "y"=>[
                            "show"=>false
                        ],
                    ],
                    "legend"=>[
                        "show"=>false
                    ]
                ]
            ]);
        ?>
    </div>
</div>