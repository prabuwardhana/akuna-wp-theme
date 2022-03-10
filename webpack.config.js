const path = require("path");
const TerserPlugin = require("terser-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");

const sourceMapEnabled = process.env.NODE_ENV !== "production";

module.exports = {
  entry: {
    main: path.resolve(__dirname, "src/js/main.js"),
    navigation: path.resolve(__dirname, "src/js/navigation.js"),
    footer: path.resolve(__dirname, "src/js/footer.js"),
  },
  output: {
    filename: "./js/[name].min.js",
    path: path.resolve(__dirname, "assets"),
  },
  optimization: {
    splitChunks: {
      chunks: "all",
    },
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
        exclude: /node_modules/,
        loader: "babel-loader",
      },
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },
          {
            loader: "css-loader",
            options: {
              sourceMap: sourceMapEnabled,
            },
          },
          {
            loader: "postcss-loader",
            options: {
              sourceMap: sourceMapEnabled,
            },
          },
          {
            loader: "sass-loader",
            options: {
              implementation: require("sass"),
              sourceMap: sourceMapEnabled,
            },
          },
        ],
      },
    ],
  },
  plugins: [
    // new CleanWebpackPlugin({}),
    new MiniCssExtractPlugin({
      filename: "./css/main.css",
    }),
  ],
  devtool: "source-map",
  watchOptions: {
    ignored: /node_modules/,
  },
};
