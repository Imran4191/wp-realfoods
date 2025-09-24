import { registerBlockType } from '@wordpress/blocks';
import { SVG } from '@wordpress/components';
import { Edit } from './edit';
import metadata from './block.json';

const PdfCheckoutFields = wt_pdf_blocks_custom_fields_params.custom_fields_arr;
const isEmptyObject = Object.keys(PdfCheckoutFields).length === 0;

if (isEmptyObject) {
} else {
	registerBlockType(metadata, {
		icon: 'smiley',
		edit: Edit,
	});
}
