var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './assets/js/main.js')
    .addStyleEntry('global', './assets/css/global.scss')
    .enableSassLoader()
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .enableSassLoader(function (sassOptions) {}, {resolve_url_loader: true})
    .configureBabel(function (babelConfig) {
        babelConfig.presets.push('es2017');
    })
    .autoProvidejQuery();

module.exports = Encore.getWebpackConfig();