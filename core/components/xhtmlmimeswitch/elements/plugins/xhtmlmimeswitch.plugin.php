<?php
/**
 * XHTML MIME Switch - Serve XML pages only to supported browsers
 *
 * Copyright (c) 2012 Gold Coast Media Ltd
 *
 * This file is part of XHTML MIME Switch.
 *
 * XHTML MIME Switch is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * XHTML MIME Switch is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * XHTML MIME Switch; if not, write to the Free Software Foundation, Inc., 59 
 * Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package xhtmlmimeswitch
 * @author  Dan Gibbs <dan@goldcoastmedia.co.uk>
 */

$event = $modx->event->name;
$resource = &$modx->resource;

if($event == 'OnWebPagePrerender')
{	
	// Header content types
	$header = (object) array(
		'xml'  => 'application/xhtml+xml',
		'html' => 'text/html',
	);

	// Get the document type
	$xml = ($resource->get('contentType') === $header->xml) ? TRUE : FALSE;

	if($xml) {
		$accepts = $_SERVER['HTTP_ACCEPT'];

		// Regex to match the client accept header
		$regex = "/\b" . str_replace('/', '\/', preg_quote($header->xml)) . "\b/i";

		// Serve as HTML to non-accepting clients
		if(!preg_match($regex, $accepts))
			$resource->ContentType->set('mime_type', $header->html);

		/*
		 * Use our own internal caching method
		 * TODO: Improve and test for performance
		 */
		$cacheable = (bool) $resource->get('cacheable');

		// Handle the cache
		if($cacheable) {
			$id = $resource->get('id');

			$cache_opts = array(
				xPDO::OPT_CACHE_KEY => 'xhtml',
			);

			$output = $modx->cacheManager->get($id, $cache_opts);

			if(empty($output)) {
				$modx->cacheManager->set($id, $resource->_output, 0, $cache_opts);
				$output = $modx->cacheManager->get($id, $cache_opts);
			}

			$resource->_content = $resource->_output = $output;
		}
	}
}
