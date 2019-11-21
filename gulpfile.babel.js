import gulp from 'gulp';
import webpackConfig from './webpack.config.js';
import webpack from 'webpack-stream';
import sass from 'gulp-sass';
import sassGlob from 'gulp-sass-glob';
import connect from 'gulp-connect-php';
import browserSync from 'browser-sync';
import notify from 'gulp-notify';
import plumber from 'gulp-plumber';
import eslint from 'gulp-eslint';


// gulpタスクの作成
function js_build() {
  return gulp
  .src('./resources/js/app.js',{
    sourcemaps: true
  })
  .pipe(plumber({
    errorHandler: notify.onError("Error: <%= error.message %>")
  }))
  .pipe(webpack(webpackConfig))
  .pipe(gulp.dest('./public/js'), {
      sourcemaps: true, // write
    });
};
function css_build() {
  return gulp.src("./resources/sass/app.scss",{
    sourcemaps: true
  })
  .pipe(plumber({
    errorHandler: notify.onError("Error: <%= error.message %>")
  }))
  .pipe(sassGlob()) // Sassの@importにおけるglobを有効にする
  .pipe(sass())
  .pipe(gulp.dest("./public/css"), {
    sourcemaps: true, // write
  });
};
function connect_sync(){
  connect.server({
    base: "public",
    // index: 'index.php',
    livereload: true,
    port: 8000,
    // bin: '/Applications/MAMP/bin/php/php7.2.10/bin/php',
    // ini: '/Applications/MAMP/bin/php/php7.2.10/conf/php.ini'
  });
  browserSync.init({
    proxy: 'localhost:8000'

  });
  // browserSync.init({
  //   server: {
  //     port: 8000,
  //     proxy: 'localhost:8000',
  //     baseDir: "./public", // 対象ディレクトリ
  //     index: "index.php" //indexファイル名
  //   }
  // });  
}
function bs_reload() {
  browserSync.reload();
};
gulp.task('eslint', function () {
  return gulp.src(['resources/js/*.js']) // lint のチェック先を指定
    .pipe(plumber({
      // エラーをハンドル
      errorHandler: function (error) {
        const taskName = 'eslint';
        const title = '[task]' + taskName + ' ' + error.plugin;
        const errorMsg = 'error: ' + error.message;
        // ターミナルにエラーを出力
        console.error(title + '\n' + errorMsg);
        // エラーを通知
        notify.onError({
          title: title,
          message: errorMsg,
          time: 3000
        })
      }
    }))
    .pipe(eslint({ useEslintrc: true })) // .eslintrc を参照
    .pipe(eslint.format())
    .pipe(eslint.failOnError())
    .pipe(plumber.stop());
});
function watch(){
  gulp.watch('./resources/sass/**', css_build);
  gulp.watch('./resources/js/**', js_build);
  // gulp.watch("./resources/views/welcome.blade.php", bs_reload);
  // gulp.watch("./public/**/*.+(js|css)", bs_reload);
  // gulp.watch("./src/**/*.js", ['eslint'])
}

// Gulpを使ったファイルの監視
// gulp.series(gulp.parallel('css-build', 'js-build', 'connect-sync'))
gulp.task('default', gulp.series(gulp.parallel(css_build, js_build),watch));
