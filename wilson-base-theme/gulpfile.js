'use strict';

var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    bower = require('gulp-bower'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    notify = require("gulp-notify"),
    imagemin = require('gulp-imagemin'),
    pngquant = require('pngquant'),
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
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.buildPath + '/css'));
});

gulp.task('images', function () {
    return gulp.src(config.imgPath + '/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest(config.buildPath + '/images'));
})


gulp.task('scripts', function () {
    return gulp.src(config.jsPath + '/**/*.js')
        .pipe(concat('build.js'))
        .pipe(uglify())
        .pipe(gulp.dest(config.buildPath + '/js'));
});


// Rerun the task when a file changes
gulp.task('watch', function () {
    gulp.watch(config.imgPath + '/*', ['images']);
    gulp.watch(config.jsPath + '/**/*.js', ['scripts']);
    gulp.watch(config.sassPath + '/**/*.scss', ['css']);
});

gulp.task('default', ['bower', 'fontawesome', 'glyphicons', 'css', 'scripts', 'images', 'watch']);