'use strict';

var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    bower = require('gulp-bower'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    notify = require("gulp-notify"),
    imageop = require('gulp-image-optimization'),
    livereload = require('gulp-livereload'),
    sourcemaps = require('gulp-sourcemaps');

var config = {
    buildPath: './build',
    jsPath: './assets/js',
    sassPath: './assets/sass',
    imgPath: './assets/images',
    bowerDir: './bower_components'
};


gulp.task('bower', function () {
    return bower()
        .pipe(gulp.dest(config.bowerDir));
});

gulp.task('fontawesome', function () {
    return gulp.src(config.bowerDir + '/fontawesome/fonts/**.*')
        .pipe(gulp.dest(config.buildPath + '/fonts'));
});
gulp.task('glyphicons', function () {
    return gulp.src(config.bowerDir + '/bootstrap-sass-official/assets/fonts/bootstrap/**.*')
        .pipe(gulp.dest(config.buildPath + '/fonts/bootstrap'));
})

gulp.task('css', function () {
    return sass(config.sassPath + '/style.scss', {
        style: 'compressed',
        sourcemap: true,
        loadPath: [
            config.sassPath,
            config.bowerDir + '/bootstrap-sass-official/assets/stylesheets',
            config.bowerDir + '/fontawesome/scss',
        ]
    })
        .pipe(concat('build.min.css'))
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.buildPath + '/css'))
	.pipe(livereload());
});

gulp.task('images', function(cb) {
    gulp.src(['src/**/*.png','src/**/*.jpg','src/**/*.gif','src/**/*.jpeg']).pipe(imageop({
        optimizationLevel: 5,
        progressive: true,
        interlaced: true
    })).pipe(gulp.dest('public/images')).on('end', cb).on('error', cb);
});


gulp.task('scripts', function () {
    return gulp.src(config.jsPath + '/**/*.js')
        .pipe(concat('build.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(config.buildPath + '/js'))
	.pipe(livereload());
});


// Rerun the task when a file changes
gulp.task('watch', function () {
    livereload.listen();
    gulp.watch(config.imgPath + '/*', ['images']);
    gulp.watch(config.jsPath + '/**/*.js', ['scripts']);
    gulp.watch(config.sassPath + '/**/*.scss', ['css']);
});

gulp.task('default', ['bower', 'fontawesome', 'glyphicons', 'css', 'scripts', 'images', 'watch']);
