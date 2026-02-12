window.data = {
	route: {
		getCategories: '{{ route('ajax.getCategories') }}',
	},
	url: {},
	old: {
		category_id: @json(old('category_id', @$transaction->category_id)),
	},
};

