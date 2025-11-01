<?php

return [
    'mode'                  => 'utf-8',
    'format'                => 'A4',
    'author'                => '',
    'subject'               => '',
    'keywords'              => '',
    'creator'               => 'ISY',
    'display_mode'          => 'fullpage',
    'tempDir'               => base_path('storage/temp/'),
    'font_path'             => base_path('storage/fonts/'),
    'font_data'             => [
		                        'vazir' => [
			                        'R' => 'vazir.ttf', // regular font
			                        'B' => 'vazir.ttf', // optional: bold font
			                        'I' => 'vazir.ttf', // optional: italic font
			                        'BI' => 'vazir.ttf', // optional: bold-italic font
			                        'useOTL' => 0xFF, // required for complicated langs like Persian, Arabic and Chinese
			                        'useKashida' => 75, // required for complicated langs like Persian, Arabic and Chinese
                                ],
                                'iran-yekan' => [
			                        'R' => 'iran-yekan.ttf', // regular font
			                        'B' => 'iran-yekan.ttf', // optional: bold font
			                        'I' => 'iran-yekan.ttf', // optional: italic font
			                        'BI' => 'iran-yekan.ttf', // optional: bold-italic font
			                        'useOTL' => 0xFF, // required for complicated langs like Persian, Arabic and Chinese
			                        'useKashida' => 75, // required for complicated langs like Persian, Arabic and Chinese
                                ],
                            ],
    'pdf_a'                 => false,
    'pdf_a_auto'            => false,
    'icc_profile_path'      => ''
];
