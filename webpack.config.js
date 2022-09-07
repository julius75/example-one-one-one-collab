const path = require("path");
const CompressionPlugin = require("compression-webpack-plugin");

module.exports = {
    module: {
        rules: [
            {
                test: /\.styl$/,
                loader: ["style-loader", "css-loader", "stylus-loader"],
            },
        ],
    },

    resolve: {
        extensions: [".js", ".json", ".vue"],
        alias: {
            "@app": path.resolve(__dirname, "./resources/frontend/platform/js"),
            "@hr": path.resolve(__dirname, "./resources/frontend/hr/js"),
            // "@sms": path.resolve(__dirname, "./resources/frontend/sms/js"),
            "@sync": path.resolve(__dirname, "./resources/frontend/sync/js"),
            "@core": path.resolve(__dirname, "./resources/frontend/core/js"),
            "@users": path.resolve(__dirname, "./resources/frontend/users/js"),
            "@theatre": path.resolve(__dirname, "./resources/frontend/theatre/js"),
            "@reports": path.resolve(__dirname, "./resources/frontend/reports/js"),
            "@finance": path.resolve(__dirname, "./resources/frontend/finance/js"),
            "@settings": path.resolve(__dirname, "./resources/frontend/settings/js"),
            "@dialysis": path.resolve(__dirname, "./resources/frontend/dialysis/js"),
            "@inpatient": path.resolve(__dirname, "./resources/frontend/inpatient/js"),
            "@inventory": path.resolve(__dirname, "./resources/frontend/inventory/js"),
            "@reception": path.resolve(__dirname, "./resources/frontend/reception/js"),
            // "@cafeteria": path.resolve(__dirname, "./resources/frontend/cafeteria/Resources/js"),
            "@evaluation": path.resolve(__dirname, "./resources/frontend/evaluation/js"),
            "@morgue": path.resolve(__dirname, "./resources/frontend/morgue/js"),
        },
    },
    plugins: [
        new CompressionPlugin(),
    ],
};
