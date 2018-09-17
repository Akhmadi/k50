<?php

return
	[
		/* route prefixes */
		'crud_prefix' => 'cruds',
		'media_prefix' => 'media',
		/* default media library settings, this can be overriden in field options */
		'media_default_settings' => [

            'resize' => [
                'width' => 1440,
                'height' => null,
                'quality' => 90
            ],
		],

		/* additional script and user components scripts declaration */

		'components' => [
			[
				'name' => 'user-components1', // just simple name
				'path' => '/js/manifest.js?000004' // path to component, must be absolute
			],
			[
				'name' => 'user-components', // just simple name
				'path' => '/js/user-components.js?000004' // path to component, must be absolute
			]
		],
        "theme" => [
            "name" => "dark",
            "colors" => [
                "primary" => "#E91E63",
                "secondary" =>"#E1BEE7",
                "accent" =>"#FF9800",
                "error" => "#f44336",
                "warning" => "#ffeb3b",
                "info" => "#2196f3",
                "success" => "#4caf50"
            ]
        ],
	"tinymce" => [ 
		"contentcss" => "",
"style_format" => [] 
	]
];