# Styling

## Requirements
To modify the CSS (`assets/css/`), [gulp.js](http://gulpjs.com/) and [Bower](https://bower.io/) are required. Both of these packages require [Node.js](https://nodejs.org/) to be installed.

When these requirements are met, go with your CLI to the `core/` directory. If you haven't installed the Node packages yet, type:

``` bash
$ npm install

```

If you haven't downloaded the JavaScript libraries with Bower yet, type:

``` bash
$ bower install

```

The directory `core/bower_components` with all JavaScript libraries will be created.

## Compile CSS
You can now concat and minify the CSS by typing:

``` bash
$ gulp styles

```

See `core/gulpfile.js` for the tasks executed.

## CSS files
The Less and Sass files used by the platform can be found in the directory `core/resources/assets/less/` and `core/resources/assets/sass/`. Also, some files in the `core/bower_components` are included in the stylesheet. All included files can be found in the file `core/gulpfile.js`.