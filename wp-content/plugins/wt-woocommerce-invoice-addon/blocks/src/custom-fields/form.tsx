import { Component, Fragment, useCallback } from '@wordpress/element';
import { __, sprintf, _n } from '@wordpress/i18n';
import { ValidatedTextInput } from '@woocommerce/blocks-checkout';

export const WtPdfBlocksCustomFieldsForm = ({ attributes, setAttributes }) => {
	const dataObject = wt_pdf_blocks_custom_fields_params.custom_fields_arr;
	const parsedData = JSON.parse(dataObject);
	const onInputChange = useCallback(
		(fieldName, value) => {
			setAttributes((prevValues) => ({
				...prevValues,
				[fieldName]: value,
			}));
		},
		[setAttributes]
	);
	return Object.keys(parsedData).map((key, index) => {
		const field = parsedData[key];
		const {
			name,
			type,
			label,
			placeholder,
			required,
			class: classes,
		} = field;

		return (
			<div className={'wt_pdf_blocks_custom_fields_elm'} key={index}>
				<ValidatedTextInput
					label={label}
					type={type}
					name={name}
					id={name}
					required={!!required}
					className={classes ? classes.join(' ') : ''}
					onChange={(e) => onInputChange(name, e)}
					value={attributes[name] || ''}
				/>
			</div>
		);
	});
};
