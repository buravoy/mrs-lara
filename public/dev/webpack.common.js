const
    path = require('path'),
    fs = require('fs'),
    webpack = require('webpack'),
    ProgressBarPlugin = require('progress-bar-webpack-plugin'),
    VueLoaderPlugin = require('vue-loader/lib/plugin'),
    MiniCssExtractPlugin = require('mini-css-extract-plugin'),
    TerserPlugin = require("terser-webpack-plugin"),
    CopyWebpackPlugin = require('copy-webpack-plugin'),

    stylesDir = path.join(__dirname, './styles/pages/'),
    styles = fs.readdirSync(stylesDir).filter(fileName => fileName.endsWith('.scss')),
    jsDir = path.join(__dirname, './scripts/pages/'),
    js = fs.readdirSync(jsDir).filter(fileName => fileName.endsWith('.js'));

module.exports = {
    entry: {
        main: [
            path.join(__dirname, './styles/')+'main.scss',
            path.join(__dirname, './scripts/')+'main.js'
        ],
        backpack: [
            path.join(__dirname, './styles/pages/')+'backpack.scss'
        ],
    },

    optimization: {
        removeEmptyChunks: true,
        splitChunks: {
            cacheGroups: {
                commons: {
                    test: /[\\/]jquery[\\/]/,
                    name: 'vendors',
                    chunks: 'all',
                },
            },
        },
        minimize: true,
        minimizer: [
            new TerserPlugin({
                extractComments: false,
            }),
        ],
    },

    module: {
        rules: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    loaders: {
                        js: 'babel-loader',
                    },
                },
            },
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {sourceMap: true}
                    }, {
                        loader: 'postcss-loader',
                        options: {sourceMap: true, config: {path: `./postcss.config.js`}}
                    }, {
                        loader: 'sass-loader',
                        options: {sourceMap: true}
                    }
                ]
            },
            {
                test: /\.(jpe?g|png|gif|svg)$/,
                use: {
                    loader: 'url-loader',
                    options: {
                        limit: 8000,
                        name(url) {
                            return path
                                .relative(path.resolve(__dirname, 'src'), url)
                                .replace(/[\\\/]+/g, '/');
                        },
                        publicPath: '..',
                    },
                },
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name(url) {
                                  return path
                                      .relative(path.resolve(__dirname), url)
                                      .replace(/[\\\/]+/g, '/');
                            },
                            publicPath: '..',
                        },
                    },
                ],
            }
        ],
    },

    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js',
            Components: path.resolve(__dirname, './components/'),
            '$': 'jquery',
            'jQuery': 'jquery',
            'window.jQuery': 'jquery',
        },
        extensions: ['.vue', '.js', '.json'],
    },

    plugins: [
        new ProgressBarPlugin(),
        new MiniCssExtractPlugin({filename: 'css/[name].css'}),
        new webpack.ProvidePlugin({
            '$': 'jquery',
            'jQuery': 'jquery',
            'window.jQuery': 'jquery',
        }),
        new VueLoaderPlugin(),
        new CopyWebpackPlugin({
            patterns: [
                {
                    from: path.resolve(__dirname, './images'),
                    to: 'images',
                }
            ],
        }),
    ],
}
//
// const chunks = {}
//
// Object.assign(chunks, ...js.map( file => {
//     const
//         key = file.replace(/\.js/, ''),
//         item = {};
//     item[key] = [null];
//     return item[key].length ? item : false;
// }))
//
// Object.assign(chunks, ...styles.map( file => {
//     const
//         key = file.replace(/\.scss/, ''),
//         item = [];
//     item[key] = [null];
//     return item[key].length ? item : false;
// }))
//
// Object.keys(chunks).forEach( key => { chunks[key] = [] });
//
// js.forEach( file => {
//     const key = file.replace(/\.js/, '');
//     chunks[key].push(jsDir + file);
// })
//
// styles.forEach( file => {
//     const key = file.replace(/\.scss/, '');
//     chunks[key].push(stylesDir + file);
// })
//
// module.exports.entry = Object.assign(module.exports.entry, chunks)
//
// console.log('Generated chunks', module.exports.entry)

