// Define the required packages
var gulp        = require('gulp'),
    fs          = require('fs'),
    jsonfile    = require('jsonfile'),
    browserSync = require('browser-sync').create(),
    concat      = require('gulp-concat'),
    wrap        = require('gulp-wrap'),
    minify      = require('gulp-minify'),
    WP          = require('wp-cli'),
    cleanCSS    = require('gulp-clean-css'),
    data        = require('gulp-data'),
    stylus      = require('gulp-stylus'),
    sourcemaps  = require('gulp-sourcemaps'),
    gutil       = require('gulp-util'),
    jshint      = require('gulp-jshint'),
    rename      = require('gulp-rename'),
    zip         = require('gulp-zip'),
    del         = require('del'),
    bisyncFiles = require('bisync-files');
    babel       = require('gulp-babel');

const autoprefixer = require('gulp-autoprefixer');

var project_settings;

/**
 * Will load dev-settings, but revert to build-settings if nothing is defined (for jenkins)
 */
try {
    project_settings = require('./dev-settings.json');
} catch (ex) {
    try {
        project_settings = require('./build-settings.json');
    }catch (ex){
        throw new gutil.PluginError({
            plugin: 'Settings Loader',
            message: gutil.colors.red('You have no settings defined!')
        });

    }
}

/**
 * Task: default (when running "gulp")
 *
 * This will:
 * Run the watch, collect-static & bi-sync-folders
 */
gulp.task('default', ['watch', 'collect-static', 'bi-sync-folders']);

/**
 * Task: build (when running "gulp build")
 *
 * This will:
 * Compile source-files
 * Minify source-files
 * Add distributable files to /theme/**theme_name**
 * Create a zip-version for use in wordpress GUI-install
 */
gulp.task('build', ['compile', 'collect-static', 'copy_synced_dirs', 'minify', 'compress'], function (cb) {
    return cb();
});

/**
 * Will watch SCSS and JS files and compile them on change.
 */
gulp.task('watch', ['compile'], function() {
    gulp.watch('stylus/**/*.styl', ['compile-css']);
    gulp.watch('js/backend/**/*.js', ['compile-js-backend', 'browser-reload']);
    gulp.watch('js/frontend/**/*.js', ['compile-js-frontend', 'browser-reload']);
    gulp.watch('js/shared/**/*.js', ['compile-js-frontend', 'compile-js-backend']);
    gulp.watch('css/**/*.css', ['collect-static', 'browser-reload']);
    project_settings.root_dir_file_extensions.forEach(function (item) {
        gulp.watch('./*.'+item, ['collect-static', 'browser-reload']);
    });
    project_settings.project_directories.forEach(function (item) {
        gulp.watch(item+'/**/*', ['collect-static', 'browser-reload']);
    });
    if(project_settings.enable_browser_sync){
        // initialize browser-sync if it is enabled in project-settings
        gulp.start('browser-sync');
    }
});

/**
 * This task will call the necessary tasks to compile the project
 */
gulp.task('compile', ['compile-js', 'compile-css'], function (cb) {
    return cb();
});

// Will compile css
gulp.task('compile-css', ['compile-css-frontend', 'compile-css-backend'], function (cb) {
    return cb();
});

gulp.task('compile-css-frontend', function () {

    return gulp.src([
        './stylus/frontend.styl'
    ])
        .pipe(sourcemaps.init())
        .pipe(stylus())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(concat(project_settings.dist+'/css/frontend.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./'))
        .pipe(browserSync.stream());
});

// Task to minify css
gulp.task('minify-css', ['compile-css'], function(cb){
    return gulp.src([
        project_settings.dist+'/css/*.css',
        '!'+project_settings.dist+'/css/*-min.css'])
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename({
            suffix: '-min'
        }))
        .pipe(gulp.dest(project_settings.dist+'/css'));
});

gulp.task('compile-css-backend', function () {
    return gulp.src([
        './stylus/backend.styl'
    ])
        .pipe(sourcemaps.init())
        .pipe(stylus())
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(concat(project_settings.dist+'/css/backend.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./'))
        .pipe(browserSync.stream());
});

// This task will compile the project javascript
gulp.task('compile-js', ['compile-js-frontend'], function (cb) {
    return cb();
});

/**
 * Task: compile-js
 *
 * This will:
 * 1) Concat all our js files into one single js file.
 * 2) Wrap the file in a wrapper file (containing jQuery noConflict etc).
 * 3) Create a minification of the output
 */
gulp.task('compile-js-frontend', ['jshint'], function() {
    return gulp.src([
        'js/shared/**/*.js',
        'js/frontend/base/**/*.js',
        'js/frontend/helpers/**/*.js',
        'js/frontend/modules/**/*.js',

        '!js/frontend/base/wrapper.js'  // Exclude the wrapper, since we will use this to wrap the concatenated files
    ])
        .pipe(babel({
            presets: ['env']
        }))
        .pipe(concat(project_settings.dist+'/js/frontend.js'))    // Concat into 1 file
        .pipe(wrap({src: 'js/frontend/base/wrapper.js'}))   // Wrap the concatenation result in a wrapper
        .pipe(gulp.dest('./'));  // Output result in js folder
});

/**
 * Task: compile-js-backend
 *
 * This will:
 * 1) Concat all our js files into one single js file.
 * 2) Wrap the file in a wrapper file (containing jQuery noConflict etc).
 * 3) Create a minification of the output
 */
gulp.task('compile-js-backend', ['jshint'], function() {
    return gulp.src([
        'js/shared/**/*.js',
        'js/backend/base/**/*.js',
        'js/backend/helpers/**/*.js',
        'js/backend/modules/**/*.js',

        '!js/backend/base/wrapper.js'   // Exclude the wrapper, since we will use this to wrap the concatenated files
    ])
        .pipe(babel({
            presets: ['env']
        }))
        .pipe(concat(project_settings.dist+'/js/backend.js')) // Concat into 1 file
        .pipe(wrap({src: 'js/backend/base/wrapper.js'}))    // Wrap the concatenation result in a wrapper
        .pipe(gulp.dest('./'));  // Output result in js folder
});

// Task to check javscript syntax and quality
gulp.task('jshint', function () {
    return gulp.src([
        'js/shared/**/*.js',
        'js/backend/base/**/*.js',
        'js/backend/helpers/**/*.js',
        'js/backend/modules/**/*.js',

        '!js/backend/base/wrapper.js'   // Exclude the wrapper, since we will use this to wrap the concatenated files
    ])
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(jshint.reporter('fail'))
});

/**
 * Compresses theme into installable zip
 */
gulp.task('compress', ['compile', 'collect-static'], function () {
    return gulp.src(project_settings.dist+'/**')
        .pipe(zip(project_settings.theme_name+'.zip'))
        .pipe(gulp.dest('./'));
});

/**
 * Deletes all compiled code and zip's.
 */
gulp.task('clean', function () {
    return del([
        project_settings.dist,
        project_settings.theme_name+".zip"
    ]);
});

/**
 * Collect static will copy static files from your root-directory based on the file-extensions defined in
 * "root_dir_file_extensions". It will also copy over all directories from "project_directories" to dist. If you add
 * new root-folders to the project these must be added to your settings.
 */
gulp.task('collect-static', function (cb) {
    project_settings.root_dir_file_extensions.forEach(function (item) {
        gulp.src('*.'+item)
            .pipe(gulp.dest(project_settings.dist+'/'))
    });
    project_settings.project_directories.forEach(function (item) {
        gulp.src(item+'/**')
            .pipe(gulp.dest(project_settings.dist+'/'+item+'/'))
    });
    return cb();
});

/**
 * This task will take all directories defined in "bisynced-dirs" and do bi-directional sync. This is specifically made
 * for ACF json-files, in order to allow editing acf-fields in a dev-environment and have the updated export-json-files
 * synced back to your sources for staging to git.
 */
gulp.task('bi-sync-folders', function (cb) {
    project_settings.bisynced_directories.forEach(function (folder) {
        bisyncFiles.watch(folder, project_settings.dist+'/'+folder);
    });
    return cb();
});

/**
 * Task is used for the build, where bidirectional sync is not needed, but you still want to copy over synced dir-files
 * to your dist-folder.
 */
gulp.task('copy_synced_dirs', function (cb) {
    project_settings.bisynced_directories.forEach(function (folder) {
        gulp.src(folder+'/**')
            .pipe(gulp.dest(project_settings.dist+'/'+folder+'/'))
    });
    return cb();
});

/**
 * Task Set: Minify (will run, when running "gulp minify")
 *
 * This will:
 * Minify your code for production
 */
//Task to run the full task-set below
gulp.task('minify', ['minify-js', 'minify-css'], function (cb) {
    return cb();
});

// Task to minify js files
gulp.task('minify-js', ['compile-js'], function () {
    return gulp.src([
        project_settings.dist+'/js/*.js',
        '!'+project_settings.dist+'/js/*-min.js'  // Exclude any minified scripts from task
    ])
        .pipe(minify()) // Create a minified script
        .pipe(gulp.dest(project_settings.dist+'/js'));  // Output result in js folder
});



// Will initialize server for browserSync
gulp.task('browser-sync', function(cb) {
    browserSync.init({
        proxy: {
            target: project_settings.development_url
        },
        reloadDelay: 300
    });
    return cb();
});

// Task to reload synced browsers (if active)
gulp.task('browser-reload', function (cb) {
    if(browserSync.active){
        browserSync.reload();
    }
    else{
        gutil.log("Browser-sync disabled in project settings");
    }
    return cb();
});

// Task will create composer.json to make theme installable by composer.
gulp.task('generate-composer-json', function (cb) {
    var composer_settings = {
        "name": project_settings.theme_name,
        "authors": project_settings.authors,
        "type": project_settings.project_type,
        "require": {
        "composer/installers": "@stable"
        }
    };
    var file = './composer.json';
    jsonfile.writeFile(file, composer_settings,{spaces: 4}, function (err) {
        if(err){
            gutil.log(err);
        }
    });
    return cb();
});