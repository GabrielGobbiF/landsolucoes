const selectAxOption = (request) => {
    return {
        valueField: 'id',
        labelField: 'name',
        load: function (query, callback) {
            var url = `${base_url_api}/${request}?search=` + encodeURIComponent(query);
            fetch(url)
                .then(response => response.json())
                .then(response => {
                    callback(response.data);
                }).catch(() => {
                    callback();
                });
        },
    }
}

const newSelect = (item) => {
    let createIn = item.dataset.create ? true : false;
    let options = {
        persist: false,
        createOnBlur: false,
        create: createIn,
        openOnFocus: true,
    }

    if (request = item.dataset.request) {
        options = Object.assign(options, selectAxOption(request))
    }

    new TomSelect(item, options);
}

document.querySelectorAll('.t-select').forEach(item => {
    newSelect(item)
})