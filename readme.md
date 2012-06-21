XHTML MIME Switcher Plugin for MODx Revolution
=========================================
*Authors: Dan Gibbs, Gold Coast Media Ltd*

A small MODx plugin that serves HTML to browsers that are not compatible with
XML processed markup. It reads the browsers 'Accept' header to see if the
'application/xhtml+xml' MIME type has been provided and changes the MODx 
document to 'text/html' if it is not present.

Intended to be used with polyglot markup without the need for any server side 
configuration.

**NOTE: This only works on MODx documents that use a Content Type serving a 'application/xhtml+xml' MIME.**

Installation
-----------
Please download and install via the MODx Revolution Package Manager.

Documentation
------------
Full detailed documentation available at:
http://www.goldcoastmedia.co.uk/tools/modx-xhtml-mime-switch
