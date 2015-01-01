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

	'ICanBoogie\Core::lazy_get_render_engines' => $hooks . 'lazy_get_engines',
	'ICanBoogie\Core::lazy_get_render_template_resolver' => $hooks . 'lazy_get_template_resolver'

];
