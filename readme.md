li3_xhprof
==========

The idea here is to make it easy to enable and disable xhprof profiling in a li3 app.

UPDATE: XHGUI now supports MongoDB, so the code here for saving ProfileRuns in mongo is no longer needed.
[https://github.com/preinheimer/xhgui](https://github.com/preinheimer/xhgui)

What now needs to happen is we need to update the xhgui submodule and make it accessible from the lithium app.
This would work in a similar way to how /test accesses the test gui if allowed.
