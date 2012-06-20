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

		$xhtml = TRUE;
		$cache_name = 'xhtml';

		// Regex to match the client accept header
		$regex = "/\b" . str_replace('/', '\/', preg_quote($header->xml)) . "\b/i";

		// Serve as HTML to non-accepting clients
		if(!preg_match($regex, $accepts)) {
			$xhtml = FALSE;
			$resource->ContentType->set('mime_type', $header->html);
		}

		/*
		 * We want to prevent MODx from caching the pages and serving
		 * them with the wrong MIME type. If caching is enabled
		 * temporarily disable it so we can manage it ourself.
		 */
		$cacheable = (bool) $resource->get('cacheable');
		$resource->set('cacheable', 0);

		// Handle the cache
		if($cacheable) {
			$id = $resource->get('id');

			$cache_opts = array(
				xPDO::OPT_CACHE_KEY => $cache_name,
			);

			$cache = $modx->cacheManager->get($id, $cache_opts);

			if(empty($cache)) {
				$modx->cacheManager->set($id, $resource->process(), 0, $cache_opts);
				$cache = $modx->cacheManager->get($id, $cache_opts);
			}
		}

		$resource->_content = $resource->_output = $cache;
	}
}
