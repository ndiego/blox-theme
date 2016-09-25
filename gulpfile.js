
var source     = 'assets/';

var gulp     = require('gulp');
var sass     = require('gulp-sass');
var rename   = require('gulp-rename');
var replace  = require('gulp-replace');
var cleanCSS = require('gulp-clean-css');
var browserSync = require('browser-sync').create();

/*// Static server
gulp.task('browser-sync', function() {
    browserSync.init({
        server: {
            baseDir: "./"
        }
    });
});

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "yourlocal.dev"
    });
});
*/


// Static Server + watching scss/html files
gulp.task('serve', ['style'], function() {

    browserSync.init({
      open: 'external',
      host: 'blox-demo',
      proxy: 'blox-demo:8888',
      //port: '8888'
    });

    gulp.watch(source + 'sass/**/*.scss',['style']);
    //gulp.watch("app/*.html").on('change', browserSync.reload);
});

gulp.task('style', function() {
  gulp.src(source + 'sass/**/style.scss')
    .pipe(sass().on('error', sass.logError)) // Log errors if they occur
    .pipe(replace('@charset "UTF-8";', '')) // Removes UTF-8 Encoding string atop CSS files
    .pipe(gulp.dest(source + 'css'))
    .pipe(browserSync.stream())
    .pipe(rename({ suffix: '-min' }))
    .pipe(cleanCSS())
    .pipe(gulp.dest(source + 'css'))
    .pipe(browserSync.stream());
});

gulp.task('default', ['serve']);




gulp.task('login', function() {
  gulp.src(source + 'sass/**/login.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(replace('@charset "UTF-8";', '')) // Removes UTF-8 Encoding string atop CSS files
    .pipe(gulp.dest(source + 'css'))
    .pipe(rename({ suffix: '-min' }))
    .pipe(cleanCSS())
    .pipe(gulp.dest(source + 'css'))
});

//Watch task
//gulp.task('default',function() {
  //gulp.watch(source + 'sass/**/*.scss',['style']);
  //gulp.watch('sass/**/login.scss',['login']);
//});
