<?php

namespace App\Http\Livewire\Qb;

use App\Http\Controllers\Qb\QbApiCore;
use App\Models\QbCachedData;
use App\Models\QuickbooksSetting;
use Livewire\Component;

class QuickbooksSettings extends Component
{
    use QbApiCore;

    public array $configurations = [];
    public array $values = [];

    public function mount(){

        $qbSettings = QuickbooksSetting::all();


        //defining the config types
        $this->configurations = [

            QuickbooksSetting::key_cardPaymentMethodReference => [
                'label' => 'Card Payment Method Reference'
            ],

             QuickbooksSetting::key_cashPaymentMethodReference => [
                'label' => 'Cash Payment Method Reference'
            ],

             QuickbooksSetting::key_dynamicTaxRateReference => [
                'label' => 'Dynamic Tax *Rate* Reference'
            ],

             QuickbooksSetting::key_lineItemTaxCodeReference => [
                'label' => 'Line Item Tax *Code* Reference'
            ],

             QuickbooksSetting::key_currencyId => [
                'label' => 'Currency ID'
            ],
        ];

        //initialize the dropdown data and the current selected value per each configuration
        foreach ($this->configurations as $propertyId => $config){
            $this->initDropdown($propertyId);
            $this->values[$propertyId] = $qbSettings->where('name', $propertyId)->first()->value??null;
        }
    }

    public function render()
    {
        return view('livewire.qb.quickbooks-settings');
    }


    /**
     * create a cache of the data  from QB, to shown in the dropdown in setting page.
     * {$propertyId} denotes a separate row / setting / data-set
     */
    public function updateList($propertyId){

        //delete existing data for the configuration
        QbCachedData::query()->where('type', $propertyId)->delete();

        $this->emit('showSpinner', ['propId' => $propertyId]); //set additional property to reach which row the spinner should animate.

        if($propertyId == QuickbooksSetting::key_dynamicTaxRateReference){
            $this->syncQbCollection(
                'QB-TaxRate',
                "SELECT * FROM TaxRate",
                (function(&$dynTaxRateRef) use($propertyId) {
                    return QbCachedData::updateOrCreate(
                        [
                            'id'    => "{$propertyId}-{$dynTaxRateRef->Id}",
                            'type'  => $propertyId,
                        ],
                        [
                            'sync_token'    => $dynTaxRateRef->SyncToken,
                            'display_label' => "{$dynTaxRateRef->Name} | RateValue:{$dynTaxRateRef->RateValue}",
                            'value'         => empty(trim($dynTaxRateRef->Id)) ? null : $dynTaxRateRef->Id,
                        ]
                    );
                })
            );

        }elseif($propertyId == QuickbooksSetting::key_cardPaymentMethodReference){
            $this->syncQbCollection(
                'QB-PaymentMethod',
                "SELECT * FROM PaymentMethod",
                (function(&$paymentMethod) use($propertyId) {
                    return QbCachedData::updateOrCreate(
                        [
                            'id'    => "{$propertyId}-{$paymentMethod->Id}",
                            'type'  => $propertyId,
                        ],
                        [
                            'sync_token'    => $paymentMethod->SyncToken,
                            'display_label' => "{$paymentMethod->Name} | Type:{$paymentMethod->Type}",
                            'value'         => empty(trim($paymentMethod->Id)) ? null : $paymentMethod->Id,
                        ]
                    );
                })
            );
        }elseif($propertyId == QuickbooksSetting::key_cashPaymentMethodReference){
            $this->syncQbCollection(
                'QB-PaymentMethod',
                "SELECT * FROM PaymentMethod",
                (function(&$paymentMethod) use($propertyId) {
                    return QbCachedData::updateOrCreate(
                        [
                            'id'    => "{$propertyId}-{$paymentMethod->Id}",
                            'type'  => $propertyId,
                        ],
                        [
                            'sync_token'    => $paymentMethod->SyncToken,
                            'display_label' => "{$paymentMethod->Name} | Type:{$paymentMethod->Type}",
                            'value'         => empty(trim($paymentMethod->Id)) ? null : $paymentMethod->Id,
                        ]
                    );
                })
            );
        }elseif($propertyId == QuickbooksSetting::key_lineItemTaxCodeReference){
            $this->syncQbCollection(
                'QB-TaxCode',
                "SELECT * FROM TaxCode",
                (function(&$dynTaxRateRef) use($propertyId) {
                    return QbCachedData::updateOrCreate(
                        [
                            'id'    => "{$propertyId}-{$dynTaxRateRef->Id}",
                            'type'  => $propertyId,
                        ],
                        [
                            'sync_token'    => $dynTaxRateRef->SyncToken,
                            'display_label' => "{$dynTaxRateRef->Name}",
                            'value'         => empty(trim($dynTaxRateRef->Id)) ? null : $dynTaxRateRef->Id,
                        ]
                    );
                })
            );
        }elseif($propertyId == QuickbooksSetting::key_currencyId){
            //hardcoded value
            QbCachedData::updateOrCreate(
                [
                    'id'    => "{$propertyId}-CAD",
                    'type'  => $propertyId,
                ],
                [
                    'sync_token'    => 0,
                    'display_label' => 'CAD',
                    'value'         => 'CAD',
                ]
            );
        }

        //update the dropdown data collection
        $this->initDropdown($propertyId);

        $this->emit('hideSpinner', ['propId' => $propertyId]);
    }

    /**
     * initialize component dropdown variable from DB data (cached data).
     */
    private function initDropdown($propertyId){
        $this->configurations[$propertyId]['options'] =
            QbCachedData::query()->where('type', $propertyId)
                ->orderBy('display_label')
                ->pluck('display_label', 'value')
                ->toArray();
    }

    /**
     * On an update check if this a dropdown change, if so save the setting to the DB.
    */
    public function updated($field, $value){

        if(str_starts_with($field,'values.')){ //if a dropdown is updated

            $type = str_replace("values.", "", $field); //primary key value

            //save the updated setting (key value pair)
            QuickbooksSetting::updateOrCreate(
                ['name' => $type],
                ['value' => $value]
            );
        }
    }
}
