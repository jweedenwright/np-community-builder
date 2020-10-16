// Imports
var gulp = require('gulp');
var concat = require('gulp-concat');

// JavaScript files that need to be concatenated
js_files = ["\\js\\vendor\\jquery-1.11.2.min.js"
    , "\\js\\vendor\\bootstrap.min.js"
    , "\\js\\vendor\\moment.min.js"
    , "\\js\\vendor\\bootstrap-datetimepicker.min.js"
    , "\\js\\global.js"
    , "\\js\\callbacks.js"
    , "\\js\\services.js"
    , "\\js\\signin.js"
    , "\\js\\signout.js"
    , "\\js\\pageload.js"
    , "\\js\\pagination.js"
    , "\\js\\report.js"
    , "\\js\\login.js"
    , "\\js\\manage.js"
]

// Generic function to run concatenation of JavaScript files
function concat_js_files(src_arr, filename) {
	return gulp.src(src_arr)
		.pipe(concat(filename))
		.pipe(gulp.dest('.'));
}

// Concat function for running all
function pass_param() {
    return new Promise(function (resolve, reject) {
        console.log("----> COMPLIATION FAILED: You must pass parameter 'js' or 'css' to compile.");
        resolve();
    });
}

// Concat function for running JavaScript Only
function build_js() {
    return concat_js_files(js_files, "\\js\\main.min.js")
}

// Setup of concat function. From command line type: gulp concat
// Minification is not done here as once we put the code into a Tag in GTM, GTM does it's own minification
exports.default = pass_param;
exports.js = build_js;