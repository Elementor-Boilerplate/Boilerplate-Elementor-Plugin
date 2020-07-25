const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyPlugin = require("copy-webpack-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
var BrowserSyncPlugin = require("browser-sync-webpack-plugin");

var NAME_PROJECT = "GFS";
var PROXY_URL = `http://localhost/${NAME_PROJECT}/`;
var URL_PLUGIN = `C:/xampp/htdocs/${NAME_PROJECT}/wp-content/plugins/elementor-${NAME_PROJECT}`;

module.exports = {
  entry: "./src/index.js",
  output: {
    filename: "[name].js",
    path: path.resolve(__dirname, URL_PLUGIN),
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: [/node_modules/],
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env"],
          },
        },
      },
      {
        test: /\.(css|sass|scss)$/,
        exclude: [/node_modules/],
        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
      },
      {
        test: /\.(jpe?g|png|gif|svg)$/i,
        loader: "file-loader",
        options: {
          name: "img/[hash].[ext]",
        },
      },
      {
        test: /\.(eot|ttf|woff)$/i,
        loader: "file-loader",
        options: {
          name: "fonts/[name].[ext]",
        },
      },
    ],
  },
  optimization: {
    minimizer: [new OptimizeCSSAssetsPlugin({})],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "style.css",
    }),
    new CopyPlugin({
      patterns: [{ from: "**/*.php" }],
    }),

    new BrowserSyncPlugin(
      {
        proxy: PROXY_URL,
        files: ["**/*.php"],
        reloadDelay: 0,
      },
      {
        reload: true,
        injectCss: true,
      }
    ),
  ],
};
