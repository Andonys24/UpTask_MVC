import { src, dest, watch, series } from 'gulp'
import gulpPlumber from 'gulp-plumber'
import * as dartSass from 'sass'
import gulpSass from 'gulp-sass'
import terser from 'gulp-terser'

const sass = gulpSass(dartSass)

const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js'
}

export function css( done ) {
    src(paths.scss, {sourcemaps: true})
    .pipe(gulpPlumber())
        .pipe( sass({
            outputStyle: 'compressed'
        }).on('error', sass.logError) )
        .pipe( dest('./public/build/css', {sourcemaps: '.'}) );
    done()
}

export function js( done ) {
    src(paths.js)
    .pipe(gulpPlumber())
      .pipe(terser())
      .pipe(dest('./public/build/js'))
    done()
}

export function dev() {
    watch( paths.scss, css );
    watch( paths.js, js );
}

export default series( js, css, dev )