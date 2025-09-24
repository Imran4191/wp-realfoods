const path = require('path');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const WooCommerceDependencyExtractionWebpackPlugin = require('@woocommerce/dependency-extraction-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

// Remove SASS rule from the default config so we can define our own.
const defaultRules = defaultConfig.module.rules.filter((rule) => {
	return String(rule.test) !== String(/\.(sc|sa)ss$/);
});

module.exports = {
	...defaultConfig,
	mode: 'development',
	entry: {
		'wt-initial-load/frontend': path.resolve(
			process.cwd(),
			'src/wt-initial-load',
			'frontend.js'
		),
		'custom-fields/frontend': path.resolve(
			process.cwd(),
			'src/custom-fields',
			'frontend.js'
		),
		'pay-later/index': path.resolve(
			process.cwd(),
			'src/pay-later',
			'index.js'
		),
	},
	output: {
		filename: '[name].js',
		path: path.resolve(__dirname, 'build'),
	},
	plugins: [
		...defaultConfig.plugins.filter(
			(plugin) =>
				plugin.constructor.name !== 'DependencyExtractionWebpackPlugin'
		),
		new WooCommerceDependencyExtractionWebpackPlugin(),
	],
};
