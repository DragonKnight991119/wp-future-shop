const path = require( 'path' );
const OptimizeJS = require( 'terser-webpack-plugin' );
const OptimizeCSS = require( 'csso-webpack-plugin' ).default;
const ExtractCSS = require( 'mini-css-extract-plugin' );
const LintStyles = require( 'stylelint-webpack-plugin' );
const RemoveStyleJS = require( 'webpack-fix-style-only-entries' );
const WebpackBar = require( 'webpackbar' );
const BrowserSync = require( 'browser-sync-webpack-plugin' );
const { WebpackManifestPlugin } = require( 'webpack-manifest-plugin' );
const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' );

const devMode = process.env.BUILD_MODEL !== 'release';
const suffix = devMode ? 'dev' : 'min';

const entry = require( './.webpack/entry' );

module.exports = {
	entry,

	mode : devMode ? 'development' : 'production',

	watch : devMode,

	cache : devMode,

	devtool : devMode ? 'source-map' : false,

	stats : {
		children    : false,
		colors      : true,
		entrypoints : false,
		modules     : true,
		version     : false,
	},

	optimization : {
		minimize  : ! devMode,
		minimizer : [
			new OptimizeJS( { extractComments : true } ),
			new OptimizeCSS(),
		],
	},

	plugins : [
		new RemoveStyleJS( { silent : true } ),
		new LintStyles(),
		new ExtractCSS( { filename : `[name].[hash].${ suffix }.css` } ),
		new BrowserSync( {
			proxy         : 'http://localhost:8888',
			host          : 'localhost',
			port          : 61988,
			files         : [ '**/*.js', '**/*.css', '**/*.php' ],
			injectChanges : true,
			open          : false,
			ui            : false,
		} ),
		new WebpackBar( {
			name    : 'Compiling...',
			profile : devMode,
		} ),
		new WebpackManifestPlugin(),
		new CleanWebpackPlugin(),
	],

	output : {
		path     : path.resolve( process.cwd(), 'dist' ),
		filename : `[name].[hash].${ suffix }.js`,
	},

	module : {
		rules : [
			{
				test    : /\.js$/,
				exclude : /node_modules/,
				use     : {
					loader  : 'babel-loader',
					options : {
						presets : [
							'@wordpress/default',
						],
					},
				},
			},

			{
				test    : /\.scss$/i,
				include : path.resolve( process.cwd(), 'sass' ),
				exclude : path.resolve( process.cwd(), 'vendor' ),
				use     : [
					ExtractCSS.loader,
					{
						loader  : 'css-loader',
						options : {
							sourceMap : true,
							url       : false,
						},
					},
					{
						loader  : 'postcss-loader',
						options : {
							postcssOptions : {
								plugins : [
									[
										'autoprefixer',
										{},
									],
								],
							},
						},
					},
					{
						loader  : 'sass-loader',
						options : {
							sourceMap   : true,
							sassOptions : {
								includePaths : path.resolve( process.cwd(), 'sass' ),
								indentType   : 'tab',
								indentWidth  : 1,
								outputStyle  : 'expanded',
							},
						},
					},
				],
			},
		],
	},
};
