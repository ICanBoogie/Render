<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render;

$hooks = __NAMESPACE__ . '\Hooks::';

return [

	'prototypes' => [

		'ICanBoogie\Core::lazy_get_renderer' => $hooks . 'lazy_get_renderer',
		'ICanBoogie\Core::render' => $hooks . 'render'

	],

	'patron.markups' => [

		'render' => [

			$hooks . 'markup_render', [

				'select' => [ 'default' => 'this', 'expression' => true, 'required' => true ],
				'as' => [ null ],
				'property' => [ null ],
				'options' => [ [] ]

			]

		]

	]

];
