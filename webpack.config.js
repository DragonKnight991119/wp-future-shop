const path = require( 'path' );

module.exports = {
	entry: './app/entry.js',
	output: {
		path: path.resolve( __dirname, 'app' ),
		filename: 'dev.js'
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /(node_modules)/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: [ '@babel/preset-env', '@babel/preset-react' ]
					}
				}
			}
		]
	}
};
