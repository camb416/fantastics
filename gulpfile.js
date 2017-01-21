var gulp = require('gulp');
// Requires the gulp-sass plugin
var sass        = require("gulp-sass");

var browserSync = require('browser-sync').create();
var sourcemaps  = require("gulp-sourcemaps");


gulp.task('sass', function(){
    return gulp.src('style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError)) // Converts Sass to CSS with gulp-sass
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(''))
        .pipe(browserSync.stream());
});



gulp.task('watch', function(){
    gulp.watch('*.scss', ['sass']);
    // Other watchers
})

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "fmag.dev"
    });
});

// Static Server + watching scss/html files
gulp.task('serve', ['sass'], function() {

    browserSync.init({
        proxy: "fmag.dev"
    });

    gulp.watch("*.scss", ['sass']);
    gulp.watch("**/*.php").on('change', browserSync.reload);
});

