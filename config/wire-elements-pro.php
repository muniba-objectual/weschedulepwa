<?php

return [
    'default' => 'bootstrap',

    'components' => [
        'modal' => [
            'view' => 'wire-elements-pro::modal.component',
            'default-behavior' => [
                'close-on-escape' => true,
                'close-on-backdrop-click' => true,
                'trap-focus' => true,
                'remove-state-on-close' => false,
            ],
            'default-attributes' => [
                'size' => 'lg',
            ],
        ],
        'slide-over' => [
            'view' => 'wire-elements-pro::slide-over.component',
            'default-behavior' => [
                'close-on-escape' => true,
                'close-on-backdrop-click' => true,
                'trap-focus' => true,
                'remove-state-on-close' => false,
            ],
            'default-attributes' => [
                'size' => 'md',
            ],
        ],
        'insert' => [
            'view' => 'wire-elements-pro::insert.component',
            'types' => [
                'user' => \App\InsertTypes\UserInsert::class,
//                'command' => \App\CommandInsert::class,
            ],
            'default-behavior' => [
                'debounce_milliseconds' => 200,
                'show_keyboard_instructions' => true,
            ]
        ]
    ],

    'presets' => [
        'tailwind' => [
            'modal' => [
                'size-map' => [
                    'xs' => 'max-w-xs',
                    'sm' => 'max-w-sm',
                    'md' => 'max-w-md',
                    'lg' => 'max-w-lg',
                    'xl' => 'max-w-xl',
                    '2xl' => 'max-w-2xl',
                    '3xl' => 'max-w-3xl',
                    '4xl' => 'max-w-4xl',
                    '5xl' => 'max-w-5xl',
                    '6xl' => 'max-w-6xl',
                    '7xl' => 'max-w-7xl',
                ],
            ],
            'slide-over' => [
                'size-map' => [
                    'xs' => 'max-w-xs',
                    'sm' => 'max-w-sm',
                    'md' => 'max-w-md',
                    'lg' => 'max-w-lg',
                    'xl' => 'max-w-xl',
                    '2xl' => 'max-w-2xl',
                    '3xl' => 'max-w-3xl',
                    '4xl' => 'max-w-4xl',
                    '5xl' => 'max-w-5xl',
                    '6xl' => 'max-w-6xl',
                    '7xl' => 'max-w-7xl',
                ],
            ]
        ],
        'bootstrap' => [
            'modal' => [
                'size-map' => [
                    'xs' => 'wep-modal-content-xs',
                    'sm' => 'wep-modal-content-sm',
                    'md' => 'wep-modal-content-md',
                    'lg' => 'wep-modal-content-lg',
                    'xl' => 'wep-modal-content-xl',
                    '2xl' => 'wep-modal-content-2xl',
                    '3xl' => 'wep-modal-content-3xl',
                    '4xl' => 'wep-modal-content-4xl',
                    '5xl' => 'wep-modal-content-5xl',
                    '6xl' => 'wep-modal-content-6xl',
                    '7xl' => 'wep-modal-content-7xl',
                ],
            ],
            'slide-over' => [
                'size-map' => [
                    'xs' => 'wep-slide-over-content-xs',
                    'sm' => 'wep-slide-over-content-sm',
                    'md' => 'wep-slide-over-content-md',
                    'lg' => 'wep-slide-over-content-lg',
                    'xl' => 'wep-slide-over-content-xl',
                    '2xl' => 'wep-slide-over-content-2xl',
                    '3xl' => 'wep-slide-over-content-3xl',
                    '4xl' => 'wep-slide-over-content-4xl',
                    '5xl' => 'wep-slide-over-content-5xl',
                    '6xl' => 'wep-slide-over-content-6xl',
                    '7xl' => 'wep-slide-over-content-7xl',
                ],
            ],
        ]
    ],
];
