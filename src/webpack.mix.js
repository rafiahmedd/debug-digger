let mix = require('laravel-mix');
var path = require('path');

mix.webpackConfig({
    module: {
        rules: [{
            test: /\.mjs$/,
            resolve: {fullySpecified: false},
            include: /node_modules/,
            type: "javascript/auto"
        }]

    },
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            '@': path.resolve(__dirname, './')
        }
    }
});

mix.js('main.js', 'main.js').vue({ version: 3 })
    .setPublicPath('../assets');