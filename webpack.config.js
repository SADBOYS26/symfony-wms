'use strict';

const NODE_ENV = process.env.NODE_ENV || 'development';
const WEBPACK = require('webpack');

let isDevelopment = NODE_ENV == 'development';
let isProduction = NODE_ENV == 'production';

//Плагин, который позволяет вычленять из лоадера готовый текст
let ExtractTextPlugin = require('extract-text-webpack-plugin');
let AssetsPlugin = require('assets-webpack-plugin');
let CleanWebpackPlugin = require('clean-webpack-plugin');

let autoprefixer = require('autoprefixer');
let css_mqpacker = require('css-mqpacker');

let path = require('path');

// Папка под которой запущен веб-сервер, чтобы ссылки генерировались с её учётом
let webDir = path.basename(path.normalize(__dirname));

module.exports = {

    //Абсолютный путь до директории с исходниками для компиляции. Нужен только для того, чтобы не писать длинные пути в entry
    context: path.join(__dirname, 'assets/src'),

    //Описание точек входа. Может быть одна или несколько. Точка входа - это такой "главный" файл для каждой
    //конкретной страницы, который содержит немодульный код. Их может быть сколь угодно много. Как правильно именно скрипт
    //точки входа подключается на странице с помощью тега <script>
    //Если какой-то файл является точкой входа, то его нельзя реквайрить ниоткуда
    //Точкой входа может быть теоретически любой файл. На каждую точку входа будет создан один js скрипт. Если точка входа
    //не является javascript'ом, то для нее все равно будет создан js скрипт, как правило пустой. Нужно следить за этим
    entry: {
        //Если в качестве значения для точки входа указать массив, то они все будут объединены в один файл
        //но экспортирован в library будет только последний элемент массива. Это полезно при создании точки входа, которая объединяет в себе
        //только общие для страницы модули
        common: './common',
        index: './index'
    },

    //Настройки вывода собранных файлов
    output: {
        //Абсолютный (важно) путь до директории со сборкой. Все файлы сборки будут попадать именно в эту директорию
        path: __dirname + '/web/assets/build/',

        //Имя файла сборки внутри path. Если используется шаблон, то [name] соответствует имени точки входа, а [id] - порядковый номер модуля
        filename: 'js/[name]' + (isProduction ? '.[chunkhash]' : '') + '.js',

        //Опция выставляет шаблон имени для AMD модулей
        chunkFilename: 'js/[id].[name]' + (isProduction ? '.[chunkhash]' : '') + '.js',

        //Будет создана глобальная переменная, куда будут экспортированы все модули, которые собирает webpack
        //шаблонное имя генерируется по аналогии с filename
        library: '[name]',

        //Путь, который указывает, как получить из интернета файлы сборки относительно path
        //Если статика отдается с cdn, то тут нужно указать полный URL до директории сборки
        //На конце должен быть /, т.к. это путь до директории. Используется почти везде, особенно в css
        publicPath: '/assets/build/'
    },

    //watch у нас работает только при разработке
    watch: isDevelopment,

    watchOptions: {
        //Ожидание после сохранения. Спустя 100ms после обнаружения изменения вебпаком будет производиться сборка
        //По дефолту значение 300, т.ч. эта опция ускоряет пересборку
        aggregateTimeout: 100
    },

    //Настройки sourcemap. Бывают разные варианты, имеет смысл подключать разные для prod и dev. Смотреть доку
    //Для разработки - cheap-inline-module-source-map
    //Для продакшна - source-map
    devtool: isProduction ? 'source-map' : 'eval',

    plugins: [
        //Плагин может пробросить переменные из данного файла конфига в сборку. Нужно использовать вместо EnvironmentPlugin
        //т.к. это удобнее. Ну и EnvironmentPlugin - это просто обмертка над DefinePlugin
        new WEBPACK.DefinePlugin({
            //Для строковых констант нужно вызывать stringify, т.к. они вставляются в сборку как есть.
            NODE_ENV: JSON.stringify(NODE_ENV),
            //Для переменных не нужно вызывать stringify
            isProduction: isProduction,
            isDevelopment: isDevelopment
        }),

        //По-умолчанию вебпак собирает сборку, даже если в процессе компилляции возникла ошибка. Этот плагин позволяет
        //предотвратить создание сборки в случае ошибок, чтобы не тратить лишнее время на поиск проблем
        new WEBPACK.NoErrorsPlugin(),

        new ExtractTextPlugin('css/[name]' + (isProduction ? '.[contenthash]' : '') + '.css'),

        new AssetsPlugin({path: __dirname + '/web/assets'}),

        new CleanWebpackPlugin(['/web/assets'])
    ],

    //Эта директива позволяет разрешать имена модулей.
    resolve: {
        //Задаем корневой путь для поиска модулей. Модули будут искаться тут и в node_modules
        root: [
            path.resolve('./assets/src/vendor'),
            path.resolve('./assets/src/modules'),
            path.resolve('./bower_components')
        ],
        fallback: ['./node_modules'],

        //Маски соответствия. Позволяют резолвить модули по алиасу
        alias: {

            //'masked.input': 'jquery.maskedinput.js'
        },

        //Директории среди всех root путей, в которых нужно искать модули. Здесь только имена директорий без всяких слешей и вложенностей
        //Просто имя последней директории среди всех root
        modulesDirectories: ['node_modules', 'js', 'vendor', 'bower_components'],

        //Расширения. Если перечислить тут расширения разных файлов, то можно в require не писать расширение
        extensions:         ['', '.js']
    },

    // полностью аналогично resolve, только применяется исключительно для loader'ов
    resolveLoader: {
        modulesDirectories: ['node_modules'],
        fallback: __dirname + "/node_modules",

        // Эта настройка содержит меньше значений, чем в дефолте. Это ускорит поиск модулей. Если нужно
        // будет подключить специфичный loader, то лучше подключить его с полным именем
        moduleTemplates:    ['*-loader', '*'],
        extensions:         ['', '.js']
    },

    module: {
        //Загрузчики используются для обработки различных типов файлов, для транспиллинга и т.д.
        //Загрузчик - это обычный nodejs модуль
        loaders: [
            {
                //Загрузчик будет применен на тех файлах, которые соответствуют регвыру из директивы test
                test: /\.js$/,

                //Babel 6й версии не завелся по мануалу, поэтому использовал тут 5й
                //опция optional[]=runtime нужна для того, чтобы внутренние функции бабеля тоже выносились в модули
                //в сборке webpack, что упростит код сборки для понимания, а также уменьшит общий размер сборки
                loader: 'babel',


                //Директива говорит о том, какие файлы исключить из обработки данным загрузчиком. Как правило библиотеки npm
                //не нуждаются в обработке babel, поэтому исключим их
                //Также в обработке не нуждаются и старые библиотеки из vendor
                exclude: [/node_modules/, /assets\/src\/vendor/, /bower_components/],

                //Зачастую exclude будет выгодней поменять на include с целью упрощения конфига
                //include: __dirname + '/my_scripts_dir'
                query: {
                    presets: [
                        'es2015'
                    ]
                }
            },

            //Загрузчики для разных расширений
            {
                test: /\.css$/,
                loader: 'style!css'
            },
            { test: /\.less$/,   loader: ExtractTextPlugin.extract('style-loader', 'css-loader!postcss-loader!less' + (isProduction ? '?compress' : '')) },

            { test: /\.(ttf|eot|woff)$/, include:/node_modules/,  loader: "file-loader?name=external[1].[ext]&regExp=node_modules(.*)" },
            { test: /\.(ttf|eot|woff)$/, exclude:/node_modules/,  loader: "file-loader?name=[path][name].[ext]" },

            { test: /\.(jpe?g|png|gif|svg)$/i, include:/node_modules/, loader: 'file-loader?name=external[1].[ext]&regExp=node_modules(.*)!img'  },
            { test: /\.(jpe?g|png|gif|svg)$/i, exclude:/node_modules/, loader: 'file-loader?name=[path][name].[ext]!img' },

            { test: /\.twig$/, loader: 'twig' }

        ]
    },
    postcss: [ autoprefixer({ browsers: ['last 3 versions'] }), css_mqpacker({sort: true}) ],
    //Директива показывает, какие файлы не нужно парсить вебпаку. Нужно быть уверенным, что в этих файлах нету вызовов
    //require например
    //noParse: /\/bitrix\/templates\//,

    //Блок для описания внешних библиотек, которые не входят в локальную сборку (напр. подключаются через CDN)
    externals: {
        //Соответствие между именем модуля, который можно реквайрить и глобальной переменной, в которую этот модуль будет записан
        jquery: '$'
    },

    stats: {
        hash: false,
        version: false,
        timings: false,
        assets: false,
        chunks: false,
        modules: false,
        reasons: false,
        children: false,
        source: false,
        errors: true,
        errorDetails: false,
        warnings: false,
        publicPath: false
    }
};

//Для прошакшена сжимаем js
if (isProduction) {
    module.exports.plugins.push(
        new WEBPACK.optimize.UglifyJsPlugin({
            compress: {
                warnings:     false,
                drop_console: true,
                unsafe:       true
            },

            //Не переименовываем переменную $
            mangle: {
                except: ['$']
            }
        })
    );
}