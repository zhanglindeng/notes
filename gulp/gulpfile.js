var gulp = require('gulp');

var jshint = require('gulp-jshint');
var less = require('gulp-less');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var jade = require('gulp-jade');
var ts = require('gulp-typescript');

//@link https://segmentfault.com/a/1190000000372547

// lint
gulp.task('lint', function() {
    gulp.src('./js/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// less
gulp.task('less', function() {
    gulp.src('./less/*.less')
        .pipe(sass())
        .pipe(gulp.dest('./css'));
});

// scripts
gulp.task('scripts', function() {
    gulp.src('./js/*.js')
        .pipe(concat('all.js'))
        .pipe(gulp.dest('./dist'))
        .pipe(rename('all.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./dist'));
});

// default
gulp.task('default', function(){
    gulp.run('lint', 'less', 'scripts');
    gulp.watch('./js/*.js', function(){
        gulp.run('lint', 'less', 'scripts');
    });
});

// ts,jade,...
