== li3_xhprof

The idea here is to make it easy to enable and disable xhprof profiling in a li3 app.

Note: the code as is only stores data to the database.  There is no front-end code for
viewing results, yet.  Feel free to contribute to that!

Runs will be stored in a `ProfileRuns` model although that's configurable.

I don't think this will work for MySQL unless the MySQL data source in Lithium
automatically serializes fields that have a schema set to object.

If you are using MySQL, you can just use XHGui and not li3_xhprof.   

The XHGui project (https://github.com/preinheimer/xhprof) is included and will be
attempted to be reused if possible.  It at least serves as a reference point.

See http://php.net/manual/en/intro.xhprof.php for more info on XHProf.


