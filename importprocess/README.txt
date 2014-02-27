file: toolboxphp/importprocess/README.txt
author: Raymond Byczko
start date: 2014-02-26

This area, known as importprocess, is the setting up
of framework for importing and processing CSV files.

The following directories are utilized:

a) lib - this contains php files specifying interfaces
and classes to accomplish the goal of import/process.
Interface files are specified with an initial 'I'.
Class files a indicated with an initial 'C'.

This library is php5 code on top of a mysql layer, the
later of which does a lot of the work.

b) lib2 - this contains an alternate implementation
to lib indicated above.  lib2 is based on fgetcsv, a php
function.  Extract information is based purely on php
code without any reliance on mysql.

c) test - contains various test harness to test out functionality
in lib and lib2.
