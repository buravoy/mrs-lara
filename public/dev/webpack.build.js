const
    path = require('path'),
    { merge } = require('webpack-merge'),
    common = require('./webpack.common.js'),
    RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts'),
    buildPath = './../';

module.exports = merge(common, {
    mode: 'production',
    output: {
        filename: 'js/[name].js',
        path: path.resolve(__dirname, buildPath),
    },
    plugins: [
        new RemoveEmptyScriptsPlugin(),
    ],
});
