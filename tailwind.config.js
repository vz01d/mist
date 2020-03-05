module.exports = {
	theme: {
		extend: {
			colors: {
				skeeg: {
					'400': '#336699',
					'500': '#5276a5'
				}
			},
			padding: {
				'42': '42px'
			},
			margin: {
				'42': '42px',
				'10': '10px'
			}
		},
		fontFamily: {
			'skeeg': '\'Luckiest Guy\',display'
		},
		fontSize: {
			'logo': '69px',
			'size-84': '84px',
			'size-42': '42px',
			'size-36': '36px',
			'size-30': '30px',
			'size-24': '24px',
			'size-22': '22px',
			'size-18': '18px'
		},
		container: {
			center: true,
			padding: '42px'
		},
		screens: {
			'sm': '640px',
			'md': '768px',
			'lg': '1024px',
			'xl': '1200px'
		}
	},
	variants: {
		padding: [ 'responsive', 'first', 'last', 'focus' ],
		margin: [ 'responsive', 'first', 'last' ],
		borderWidth: [ 'responsive', 'first', 'last' ]
	},
	plugins: []
};
