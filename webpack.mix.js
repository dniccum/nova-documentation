let mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')
require('laravel-mix-purgecss');
require('./mix')

mix.setPublicPath('dist')
    .js('resources/js/tool.js', 'js')
    .sass('resources/sass/tool.scss', 'css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js'), ],
    })
    .webpackConfig({
        output: {
            chunkFilename: '[name].js?id=[chunkhash]',
        }
    })
    .disableSuccessNotifications()
    .vue({ version: 3 })
    .nova('dniccum/nova-documentation');

if (!mix.inProduction()) {
    mix.sourceMaps();
}
