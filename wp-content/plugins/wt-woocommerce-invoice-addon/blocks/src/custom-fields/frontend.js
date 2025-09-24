import metadata from './block.json';
import { __ } from '@wordpress/i18n';
import {
	useEffect,
	useState,
	useCallback,
	useDispatch,
} from '@wordpress/element';
import { WtPdfBlocksCustomFieldsForm } from './form.tsx';
const { registerCheckoutBlock } = wc.blocksCheckout;
const Block = ({ children, checkoutExtensionData }) => {
	const wt_checkout_fields =
		wt_pdf_blocks_custom_fields_params.custom_fields_arr;
	const parse_wt_checkout_fields = JSON.parse(wt_checkout_fields);
	const initialState = Object.keys(parse_wt_checkout_fields).reduce(
		(acc, key) => {
			acc[key] = '';
			return acc;
		},
		{}
	);
	const [attributes, setAttributes] = useState(JSON.stringify(initialState));
	const { setExtensionData } = checkoutExtensionData;
	if (Object.keys(parse_wt_checkout_fields).length > 0) {
		Object.keys(parse_wt_checkout_fields).forEach((key, value) => {
			useEffect(() => {
				setExtensionData('wt_pdf_blocks', key, attributes[key]);
			}, [attributes]);
		});
	}
	return (
		<div className={'wt_pdf_blocks_custom_fields_wrap'}>
			<WtPdfBlocksCustomFieldsForm
				attributes={attributes}
				setAttributes={setAttributes}
			/>
		</div>
	);
};

const option = {
	metadata,
	component: Block,
};
registerCheckoutBlock(option);
