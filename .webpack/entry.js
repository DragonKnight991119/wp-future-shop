const path = require( 'path' );
const glob = require( 'glob' );
const { paramCase } = require( 'change-case' );

// Match all the blocks, excluding the dist and node module directories.
const assets = glob.sync( './!(dist|node_modules|vendor)/**/+(index|editor|style|script).+(js|scss)' );

const entry = {};

// Process the asset and add to entires.
for ( const asset of assets ) {
	// Split asset into an array and shift off the first item.
	const data = asset.split( '/' );
	data.shift();

	let entryName = paramCase( data[ data.length - 2 ] );

	if ( data[ 1 ].includes( 'editor' ) ) {
		entryName += '-editor';
	}

	entry[ entryName ] = asset;
}

module.exports = entry;
