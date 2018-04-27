const gulp = require("gulp");
const sass = require("gulp-sass");
const pump = require("pump");
const cssmin = require("gulp-cssmin");

gulp.task("sass", function(){
    pump([
        gulp.src("./assets/scss/*.scss"),
        sass(),
        cssmin(),
        gulp.dest("./assets/css/")
    ]);
});

gulp.task("watch", function(){
    gulp.watch("./assets/scss/*.scss", ["sass"]); 
});