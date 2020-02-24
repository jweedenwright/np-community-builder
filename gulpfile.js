// Imports
var gulp = require('gulp');
var concat = require('gulp-concat');

// Files that need to be concatenated
files = ["\\js\\vendor\\jquery-1.11.2.min.js"
    , "\\js\\vendor\\bootstrap.min.js"
    , "\\js\\vendor\\moment.min.js"
    , "\\js\\vendor\\bootstrap-datetimepicker.min.js"
    , "\\js\\vendor\\chart.bundle.min.js"
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

// Generic function to run concatenation of files
function concat_files(src_arr, filename) {
	return gulp.src(src_arr)
		.pipe(concat(filename))
		.pipe(gulp.dest('.'));
}

// Product-specific Concat Functions
function concat_all() {
	return concat_files(files, "\\js\\main.min.js")
}

// Setup of concat function. From command line type: gulp concat
// Minification is not done here as once we put the code into a Tag in GTM, GTM does it's own minification
exports.default = concat_all;