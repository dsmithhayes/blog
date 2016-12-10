'use strict';

var gulp      = require('gulp'),
    sass      = require('gulp-sass'),
    rename    = require('gulp-rename'),
    minifycss = require('gulp-minify-css'),
    uglify    = require('gulp-uglify');

var src        = './src',
    dist       = './public',
    scss       = '/scss',
    css        = '/css',
    js         = '/js',
    images     = '/images',
    all_js     = '/**/*.js',
    all_scss   = '/**/*.scss',
    all_css    = '/**/*.css',
    all_images = '/**/*';

// Combines and uglifies the JavaScript, places it in the document root
gulp.task('js', function() {
  return gulp.src(src + js + all_js)
             .pipe(uglify())
             .on('error', (err) => {
               console.log('Error uglifying the JavaScript: ' + err);
               return false;
             })
             .pipe(rename({suffix: '.min'}))
             .pipe(gulp.dest(dist + js));
});

// Builds the CSS out of the SASS.
gulp.task('sass', function() {
  return gulp.src(src + scss + all_scss)
             .pipe(sass().on('error', sass.logError))
             .pipe(minifycss())
             .pipe(rename({ suffix: '.min' }))
             .pipe(gulp.dest(dist + css));
});

// Places the final compiled CSS file into the document root, this css must live
// in the SCSS directory
gulp.task('css', function() {
  return gulp.src(src + scss + all_css)
             .pipe(sass().on('error', sass.logError))
             .pipe(gulp.dest(dist + css));
});

gulp.task('images', function() {
  return gulp.src(src + images + all_images)
             .pipe(gulp.dest(dist + images));
});

// Watches for changes to files within the SASS and JS directories
gulp.task('watch', function() {
  gulp.watch(src + scss + all_scss, ['sass', 'css']);
  gulp.watch(src + js + all_js, ['js']);
});

// Compiles the SASS, puts the CSS into the document root, along with the JS
gulp.task('default', ['sass', 'css', 'js', 'images']);
