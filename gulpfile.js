var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('default', function() {
  // place code for your default task here
});

gulp.task('style', function() {
    gulp.src('sass/**/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./'))
});

gulp.task('login', function() {
    gulp.src('sass/**/login.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./'))
});

//Watch task
gulp.task('default',function() {
  gulp.watch('sass/**/style.scss',['style']);
  gulp.watch('sass/**/login.scss',['login']);
});
