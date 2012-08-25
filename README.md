Overview
========
CacheIt is a script based dynamic module kernel. CacheIt’s main goal is to provide an easy-to-use and efficient system for using, loading and caching modules and their output.

CacheIt does require write access to your cache directory if you will be using the cache to disk option. If you do not know how to modify directory permissions, please check with your system admin.


Starting Out – Creating the Object
----------------------------------

To start out, I need to explain a few things. Whenever I refer to {INCLUDEDIR}, I’m referring to the directory of where class.CacheIt.php is located. When I refer to {MODULEDIR}, I’m referring to where the CacheIt modules reside. When I refer to {CACHEDIR}, I’m referring to the directory where the cached files will be stored if you use the file cashing option. For the sake of sanity, I will refer to the created object as $cache for the remainder of the tutorial. All italicized text is actual code.

INCLUDE class.CacheIt.php.

	include("{INCLUDEDIR}/class.CacheIt.php");

Create a NEW instance of the object.

	$cache = new CacheIt{"{CACHEDIR}","{MODULEDIR}");

That’s it. At this point, you have a new CacheIt object named $cache ready for use. Incase you would like to cut and paste a working example, I’ve included one (I assumed the directories for you since they seem logical).

	include("/include/class.CacheIt.php");
	$cache = new CacheIt{"/cache","/include/modules");

Note. If you want to have two CacheIt objects within the same script (I still haven’t figured out a reason to do this) you do not need to re-include the class.CacheIt.php file. Once a file is INCLUDED in PHP, it remains in memory until the script is completed.


Using Your First Module
-----------------------

While the following may seem quite daunting, I assure you, it’s not, and it will become old-hat soon enough.

The main function for CacheIt is known as disp_file. Disp_file has a number of arguments, some are required, and others are not. Non-required fields are marked in []’s. If you do not have a firm grasp of using functions with variable number of arguments, please visit http://www.php.net.

disp_file(string cache_file , string module_name [, array module_arguments [, int time_out [, int cache_method ]]] )

Here is a breakdown of the arguments:

cache_file – The actual file name that you would like to be written out for the file cache.
Note. This is how CacheIt references the cached output internally and comes to use even if you’re using a time_out of –1. If you are using a time_out of –1, please read cache_method for further details.
module_name – The module that will be run if the cache_file is either missing or out of time_out.
Note. The module named here must be located in the {MODULEDIR}.
module_arguments – An array of arguments to be sent to the module incase of the module needing to be run. If you are unfamiliar with the ARRAY syntax of PHP, please visit http://www.php.net for more info.
Example array. array("site"=>"Slashdot","url"=>"http://www.slashdot.org")
time_out – The amount of seconds to allow to pass before the cached file needs to be refreshed.
Note: Default for time_out is 3600 seconds (1 hour).
Note: You can assign time_out a value of –1 (negative one) to have CacheIt not generate a cache file.
cache_method – Defines the method that CacheIt will use for caching to memory. 0 = No memory Caching. 1 = Memory Caching. 2 = Semaphore Caching (Not yet available).
Note: The default for cache_method is 0. Always use 0 unless you will have multiple calls to disp_file in the same script that use the same cache_file.

First Module Examples
---------------------

	$cache->disp_file("boad.cache", "get_news");

This example demonstrates the smallest possible disp_file. It will run get_news if the file boad.cache is missing or the file time is older than one hour and it will not cache the results to memory.

	$cache->disp_file("boad.cache", "get_news", array("site"=>"Slashdot","url"=>"http://www.slashdot.org"));

This example will run get_news with the arguments of site and url if the file boad.cache is missing or the file time is older than one hour and it will not cache the results to memory.

	$cache->disp_file("boad.cache", "get_news", array("site"=>"Slashdot","url"=>"http://www.slashdot.org"),86400);

This example will run get_news with the arguments of site and url if the file boad.cache is missing or if the file time is older than one day and it will not cache the results to memory.

	$cache->disp_file("boad.cache", "get_news", array("site"=>"Slashdot","url"=>"http://www.slashdot.org"),86400,1);

This example will run get_news with the arguments of site and url if the file boad.cache is missing or the file time is older than one day and it will cache the results to memory.

	$cache->disp_file("boad.cache", "get_news", array("site"=>"Slashdot","url"=>"http://www.slashdot.org"),-1,1);

This example will run get_news with the arguments of site and url and it will cache the results to memory. Note. This example WILL NOT write out a cache file, and it will run the module EVERY time this disp_file is called.


Creating Your Own Module
------------------------

Creating your own module is a lot easier than you would believe, or as I’ll have you believe. (Insert maniacal laugh here.. You must at least be famialiar with functions, if you are not, please check out http://www.php.net.

The rules are fairly simple: Your module must be named with the exact same name as the function inside. If you wanted to create a module called get_news, the file would be named get_news.php and the function inside get_news.php would be called…. Yep, you guessed it, get_news. 

Your module’s function only needs one argument, and you can name it anything you would like. I prefer $arglist, so I’ll use that throughout the tutorial. To access the variables passed through $arglist from CacheIt, you would refrence it as $arglist["{VARIABLE}"]. The {VARIABLE} is the identifier passed by the array. So, if array("site"=>"Slashdot","url"=>"http://www.slashdot.org") was passed to your function, you would refrence the site variable by $arglist["site"]. Simple enough, eh. Good.

There are just a few more little tidbits that you need to know.

Returning Your Results – All you need to do is trap your results to a variable (formatted the way you wish it to look) and return it using PHP’s return.
Including Files – Please use include_once instead of include. This makes sure PHP does not stop with errors if you attempt to include a file more than once.
Objects – If you are going to use an object in your module, please check for its existence before recreating it. This will save you many hours of time and your modules will actually work properly. Please remember the including rules when working with objects.

Copyright (c) 2000 Andrew M Riley 

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
