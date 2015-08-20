'use strict';

var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-ruby-sass'),
    notify = require("gulp-notify"),
    bower = require('gulp-bower'),
    sourcemaps = require('gulp-sourcemaps');

var config = {
    jsPath: './assets/js',
    sassPath: './assets/sass',
    bowerDir: './bower_components'
};


gulp.task('bower', function () {
    return bower()
        .pipe(gulp.dest(config.bowerDir));
});

gulp.task('icons', function () {
    return gulp.src(config.bowerDir + '/fontawesome/fonts/**.*')
        .pipe(gulp.dest('./build/fonts'));
});

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
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./build/css'));
});


gulp.task('scripts', function () {
    return gulp.src(config.jsPath + '/**/*.js')
        .pipe(concat('build.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./build/js'));
});


// Rerun the task when a file changes
gulp.task('watch', function () {
    gulp.watch(config.sassPath + '/**/*.scss', ['css']);
    gulp.watch(config.jsPath + '/**/*.js', ['scripts']);
});

gulp.task('default', ['bower', 'icons', 'css', 'scripts', 'watch']);