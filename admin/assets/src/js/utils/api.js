/* global MMAOCFCA */
export const fetchGetOptions = () => {
	return {
		headers: {
			"X-WP-Nonce": MMAOCFCA.NONCES.REST,
		},
	};
}

export const fetchPostOptions = ( postData ) => {
	return {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
			"X-WP-Nonce": MMAOCFCA.NONCES.REST,
		},
		body: JSON.stringify(postData),
	};
}

export const fetchPostFileUploadOptions = ( formData ) => {
	return {
		method: 'POST',
		headers: {
			'X-WP-Nonce': MMAOCFCA.NONCES.REST,
		},
		body: formData,
	}
}
