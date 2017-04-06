# Scripts

## Requirements
To modify the JavaScript files (`assets/js/`), [gulp.js](http://gulpjs.com/) and [Bower](https://bower.io/) are required. Both of these packages require [Node.js](https://nodejs.org/) to be installed.

When these requirements are met, go with your CLI to the `core/` directory. If you haven't installed the Node packages yet, type:

``` bash
$ npm install

```

If you haven't downloaded the JavaScript libraries with Bower yet, type:

``` bash
$ bower install

```

The directory `core/bower_components` with all JavaScript libraries will be created.

## Compile JavaScripts
You can now concat and minify the JavaScripts by typing:

``` bash
$ gulp scripts

```

See `core/gulpfile.js` for the tasks executed.

## JavaScript files
The JavaScript files used by the platform can be found in the directory `core/resources/assets/js/`. Also, some files in the `core/bower_components` are included in the JavaScript files. All included files can be found in the file `core/gulpfile.js`.