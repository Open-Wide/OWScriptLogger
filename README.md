OWScriptLogger
==============

__Extension__ : OW Script Logger v1.0

__Requires__ : eZ Publish 4.x.x (not tested on 3.X)

__Author__ : Open Wide <http://www.openwide.fr>

What is OWScriptLogger?
-------------------

OW Script Logger provides a class to log events in different files depending on the script started. The logs are also recorded in database and visible from the back-end.
 
Usage
------
1. At the beginning of your script, instantiate the logger :
```php
OWScriptLogger::startLog( $script_identifier );
```

2. In the script, log events with these methodes :
```php
OWScriptLogger::logNotice( $message, $action );
OWScriptLogger::logWarning( $message, $action );
OWScriptLogger::logDelete( $message, $action );
```

Enjoy !!


License
-------

This program is free software; you can redistribute it and/or
modify it under the terms of version 2.0 of the GNU General
Public License as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

Read /LICENSE


Installation
------------

1. Activate the extension OWScriptLogger.
2. Clear cache and regenerate autoloads.
