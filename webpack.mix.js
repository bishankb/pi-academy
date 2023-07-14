let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*
 |--------------------------------------------------------------------------
 | Backend
 |--------------------------------------------------------------------------
 |
 */

mix.scripts([
    'resources/assets/metronic/global/plugins/jquery.min.js',
  	'resources/assets/metronic/global/plugins/bootstrap/js/bootstrap.min.js',
  	'resources/assets/metronic/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.min.js',
    'resources/assets/metronic/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
  	'resources/assets/metronic/global/scripts/app.min.js',
  	'resources/assets/metronic/pages/scripts/components-date-time-pickers.min.js',
  	'resources/assets/metronic/layouts/layout/scripts/layout.min.js',
    'resources/assets/backend/js/labelError.js',
    'resources/assets/backend/js/ui-sweetalert.min.js',
    'resources/assets/metronic/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker3.min.js',
    'resources/assets/metronic/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
    'resources/assets/metronic/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
    'resources/assets/nepali.datepicker/nepali.datepicker.v2.2.min.js',
    'resources/assets/metronic/global/plugins/bootstrap-sweetalert/sweetalert.min.js',
    'resources/assets/metronic/global/plugins/select2/js/select2.min.js',
    'resources/assets/metronic/global/plugins/amcharts/amcharts/amcharts.js',
    'resources/assets/metronic/global/plugins/amcharts/amcharts/serial.js',
    'resources/assets/metronic/global/plugins/amcharts/amcharts/pie.js',
    'resources/assets/metronic/global/plugins/amcharts/amcharts/themes/light.js',
    'resources/assets/backend/js/xlsx.core.min.js',
    'node_modules/file-saverjs/FileSaver.min.js',
    'node_modules/tableexport/dist/js/tableexport.min.js',
    'node_modules/lightbox2/src/js/lightbox.js',
    'resources/assets/backend/js/script.js',
    'resources/assets/backend/js/custom.js',
], 'public/js/backend.js');

mix.scripts([
    'resources/assets/backend/js/ckeditor.config.js',
], 'public/js/ckeditor.config.js');

mix.styles([
    'resources/assets/metronic/global/plugins/bootstrap/css/bootstrap.min.css',
    'resources/assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css',
    'resources/assets/metronic/global/plugins/simple-line-icons/simple-line-icons.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css',
    'resources/assets/metronic/global/css/components.min.css',
    'resources/assets/metronic/global/css/search.min.css',
    'resources/assets/metronic/global/css/plugins.min.css', 
    'resources/assets/metronic/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css',
    'resources/assets/metronic/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
    'resources/assets/metronic/layouts/layout/css/layout.min.css',
    'resources/assets/metronic/layouts/layout/css/themes/darkblue.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
    'resources/assets/nepali.datepicker/nepali.datepicker.v2.2.min.css',
    'resources/assets/metronic/layouts/layout/css/custom.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-sweetalert/sweetalert.css',
    'resources/assets/metronic/global/plugins/select2/css/select2.min.css',
    'resources/assets/metronic/global/plugins/select2/css/select2-bootstrap.min.css',
    'resources/assets/metronic/global/css/plugins.min.css',
    'resources/assets/metronic/global/css/plugins.min.css',
    'node_modules/tableexport/dist/css/tableexport.min.css',
    'node_modules/lightbox2/src/css/lightbox.css',
    'resources/assets/toggleSwitch/toggle-switch.css',
    'resources/assets/backend/css/semantic-label.css',
    'resources/assets/backend/css/abs.css',
    'resources/assets/backend/css/custom.css',
], 'public/css/backend.css');


mix.copyDirectory('resources/assets/backend/images', 'public/images');
mix.copyDirectory('resources/assets/backend/fonts', 'public/fonts');
mix.copyDirectory('resources/assets/metronic/global/plugins/font-awesome/fonts', 'public/fonts');
mix.copyDirectory('resources/assets/metronic/global/plugins/simple-line-icons/fonts', 'public/css/fonts');
mix.copyDirectory('resources/assets/metronic/global/plugins/bootstrap/fonts/bootstrap', 'public/fonts/bootstrap');
mix.copyDirectory('resources/assets/metronic/global/plugins/ckeditor', 'public/plugins/ckeditor');
mix.copyDirectory('node_modules/lightbox2/src/images', 'public/images');
mix.copyDirectory('resources/assets/nepali.datepicker/images', 'public/css/images');
mix.copyDirectory('node_modules/tableexport/dist/img', 'public/img');


/*
 |--------------------------------------------------------------------------
 | Backend Auth
 |--------------------------------------------------------------------------
 |
 */
mix.styles([
    'resources/assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css',
    'resources/assets/metronic/global/plugins/simple-line-icons/simple-line-icons.min.css',
    'resources/assets/metronic/global/plugins/bootstrap/css/bootstrap.min.css',
    'resources/assets/metronic/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
    'resources/assets/metronic/global/plugins/select2/css/select2.min.css',
    'resources/assets/metronic/global/plugins/select2/css/select2-bootstrap.min.css',
    'resources/assets/metronic/global/css/components.min.css',
    'resources/assets/metronic/global/css/plugins.min.css',
    'resources/assets/metronic/global/css/login.min.css'
], 'public/css/auth.css');

/*
 |--------------------------------------------------------------------------
 | Exam
 |--------------------------------------------------------------------------
 |
 */

mix.scripts([
    'resources/assets/metronic/global/plugins/jquery.min.js',
    'node_modules/jquery-validation/dist/jquery.validate.js',
    'node_modules/toastr/toastr.js',
    'resources/assets/metronic/global/plugins/bootstrap/js/bootstrap.min.js',
    'node_modules/virtual-keyboard/dist/js/jquery.keyboard.min.js',
    'node_modules/virtual-keyboard/dist/js/jquery.keyboard.extension-all.min.js',
    'resources/assets/exam/js/custom.js',
], 'public/js/exam.js');

mix.styles([
    'resources/assets/metronic/global/plugins/bootstrap/css/bootstrap.min.css',
    'resources/assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css',
    'node_modules/toastr/build/toastr.css',
    'node_modules/virtual-keyboard/dist/css/keyboard.min.css',
    'node_modules/virtual-keyboard/dist/css/keyboard-basic.min.css',
   'resources/assets/exam/css/custom.css',
], 'public/css/exam.css');


mix.copyDirectory('resources/assets/exam/images', 'public/images');
mix.copyDirectory('resources/assets/exam/fonts', 'public/fonts');

/*
 |--------------------------------------------------------------------------
 | Error Page
 |--------------------------------------------------------------------------
 |
 */

mix.styles([
    'resources/assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css',
    'resources/assets/error/css/style.css',
], 'public/css/error.css');

mix.copyDirectory('resources/assets/error/images', 'public/images');