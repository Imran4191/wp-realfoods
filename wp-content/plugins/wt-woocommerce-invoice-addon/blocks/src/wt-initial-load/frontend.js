import metadata from './block.json';
import { __ } from '@wordpress/i18n';
import {
	useEffect,
	useState,
	useCallback,
	useDispatch,
} from '@wordpress/element';
const { registerCheckoutBlock } = wc.blocksCheckout;
const Block = ({ children, checkoutExtensionData }) => {
	const [attributes, setAttributes] = useState();
	const { setExtensionData } = checkoutExtensionData;
	useEffect(() => {
		setExtensionData('wt_pdf_blocks');
	}, [attributes]);
	return '';
};
const option = {
	metadata,
	component: Block,
};
registerCheckoutBlock(option);
