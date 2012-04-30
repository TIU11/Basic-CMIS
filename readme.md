# Basic CMIS for Wordpress

**Contributors**:       [ansonhoyt](https://twitter.com/ansonhoyt @ansonhoyt)

**Tags**:               cmis, alfresco

**Requires at least**:  3.3.1 (let us know if it works on an earlier version)

**Tested up to**:       3.3.2

**Plugin URI**:         https://github.com/ansonhoyt/Basic-CMIS

**Version**:            0.0.2

**Author**:             Anson Hoyt

**Author URI**:         https://github.com/ansonhoyt

**License**:            LGPLv3

## Description

Wordpress Plugin for basic CMIS integration. Searches a CMIS compliant system and renders the matching documents. Tested with Alfresco Enterprise's CMIS service, but should work with any [CMIS](http://en.wikipedia.org/wiki/Content_Management_Interoperability_Services)  compatible source (e.g. Microsoft Sharepoint, Alfresco).

## Installation

1. Pull down the code from Github.
2. Create a `basic-cmis` folder under your Wordpress plugins folder.
3. Upload the code to the new folder.
4. Activate the plugin through the 'Plugins' menu in WordPress
5. Configure the plugin via the Admin panel. You must provide a CMIS url, username and password. This is used sitewide.
6. Use the `cmis` shortcode in your content.

## Usage

Use the `[cmis]` shortcode to retrieve documents and render them.
* Docs in a folder: `[cmis folder="/my particular/folder name/"]`
* Docs in the folder, including subfolders: `[cmis tree="/my particular/folder name/"]`
* Docs containing the keywords: `[cmis keywords="coffee tea"]`
* Docs whose name matches. May include wildcard character '%': `[cmis name="Agenda%.doc"]`
* Combinations of parameters: `[cmis folder="/documents" keywords="bacon" name="%menu%.pdf"]`

## Todo

* Display options:
  `[cmis display_options="show_icon show_modified_date hide_title"`
* Render a suitable title:
  * `[cmis folder="/My Documents"]` => "Documents in /My Documents"
  * `[cmis tree="/My Documents"]` => "Documents in /My Documents"
  * `[cmis keywords="coffee"]` => "Documents containing 'coffee'"
  * `[cmis name="%Agenda%"]` => "Documents named '%Agenda%'"

## Contribute

If you have found a bug or have a feature to request, please add it to the [GitHub issue tracker](https://github.com/ansonhoyt/Basic-CMIS/issues), or fork the project and send a pull request.

## License

Copyright 2012 Tuscarora Intermediate Unit

This file is part of Basic CMIS for WordPress.

Basic CMIS for WordPress is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Basic CMIS for WordPress is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Basic CMIS for WordPress.  If not, see [http://www.gnu.org/licenses/].
