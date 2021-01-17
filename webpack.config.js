const path = require( 'path' );

module.exports = {
	entry: './admin/app/entry.js',
	output: {
		path: path.resolve( __dirname, 'dist' ),
		filename: 'dev.js' // @todo Ensure this outputs the file name based on the mode.
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
