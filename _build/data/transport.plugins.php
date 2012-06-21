<?php
/**
 * XHTML MIME Switch transport plugins
 * Copyright 2012 Gold Coast Media
 * @author Dan Gibbs <dan@goldcoastmedia.co.uk>
 * 21/7/12
 *
 * XHTML MIME Switch is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * XHTML MIME Switch is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * XHTML MIME Switch; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package xhtmlmimeswitch
 * @subpackage build
 */

if (! function_exists('getPluginContent')) {
    function getpluginContent($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<?php','',$o);
        $o = str_replace('?>','',$o);
        $o = trim($o);
        return $o;
    }
}
$plugins = array();

$plugins[1]= $modx->newObject('modplugin');
$plugins[1]->fromArray(array(
    'id' => 1,
    'name' => 'XHTML MIME Switch',
    'description' => 'XHTML MIME Switch Plugin',
    'plugincode' => getPluginContent($sources['source_core'].'/elements/plugins/xhtmlmimeswitch.plugin.php'),
),'',true,true);


return $plugins;
