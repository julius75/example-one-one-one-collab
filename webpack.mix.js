const mix = require("laravel-mix");
const config = require("./webpack.config");

/*
 |--------------------------------------------------------------------------
 | Mix Config Management
 |--------------------------------------------------------------------------
 |
 | Set some webpack extra functionality here
 |
 */
mix.webpackConfig(config);

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

mix.options({
    terser: {
        terserOptions: {
            warnings: true,
        },
    },
});


mix.js("resources/frontend/platform/js/app.js", "public/js")
    .extract([
        "chart.js", "epic-spinners", "install", "laravel-echo", "moment",
        "numeral", "open-sans-all", "pluralize", "popper.js", "pusher-js", "quill",
        "quill-better-table", "sweetalert2", "tinymce", "underscore",
        "v-router-transition", "vue-json-excel", "vue-moment", "vue-quill-editor", "vue-router",
        "vue-signature", "vue-sweetalert2", "vue-tinymce-editor", "vue-underscore", "vue2-autocomplete-js",
        "vuetify", "vue", "vuex", "vue-barcode", "vue-chartjs", "vue-datatables-net", "vue-style-loader",
    ])
    .sass("resources/frontend/platform/sass/app.scss", "public/css");

mix.js("resources/frontend/websockets/index.js", "public/js/app.js")

if (mix.inProduction()) {
    mix.options({
        terser: {
            terserOptions: {
                compress: {
                    drop_console: true,
                },
            },
        },
    });
    mix.version();
}
