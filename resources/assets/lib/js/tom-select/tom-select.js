/*
USAGE:
 <select id="select--users_name" name="user_id" class="form-control select-users_name t-select table-search_input"
        data-request="{{ route('api.table.users') }}" data-value-field="uid" required>
</select>
*/
const selectAxOption = (request, valueField, queryParams = {}) => {
    return {
        valueField: valueField,
        labelField: 'name',
        searchField: 'search',
        preload: true,
        firstUrl: function (query) {
            // Converte o objeto `queryParams` em uma string de query
            const queryString = new URLSearchParams(queryParams).toString();
            const delimiter = request.includes('?') ? '&' : '?';
            return `${request}${delimiter}${queryString}&search=${encodeURIComponent(query)}&pageSize=30`;
        },
        load: function (query, callback) {
            // Converte o objeto `queryParams` em uma string de query
            const queryString = new URLSearchParams(queryParams).toString();
            const delimiter = request.includes('?') ? '&' : '?';
            var url = `${request}${delimiter}${queryString}&search=${encodeURIComponent(query)}&pageSize=30`;

            fetch(url)
                .then(response => response.json())
                .then(response => {
                    callback(response.data);
                }).catch(() => {
                    callback();
                });
        },
        onItemAdd: function (value, item) {
            this.setTextboxValue('');
        }
    }
}

window.newSelect = (item) => {
    let i_url = document.querySelector('meta[name="url"]').content
    let createIn = item.dataset.create ? true : false;
    let request = item.dataset.request;
    let valueField = item.dataset.valueField ?? 'id';
    let searchTableCloset = item.dataset.searchTable ?? null;
    let itemId = `${item.id}__${i_url}`;
    let localSaveStorage = localStorage.getItem(`${item.id}__${i_url}`);
    let queryParams = {};

    if (item.dataset.query) {
        try {
            queryParams = JSON.parse(item.dataset.query.replace(/=>/g, ':'));
        } catch (error) {
            console.error('Erro ao processar data-query: ', error);
        }
    }

    let options = {
        persist: false,
        createOnBlur: false,
        create: createIn,
        openOnFocus: true,
        maxOptions: null,
        onChange: function (values) {
            if (item.classList.contains('search'))
                localStorage.setItem(itemId, values)
        }
    }

    if (request) {
        options = Object.assign(options, selectAxOption(request, valueField, queryParams))
    }

    if (item.getAttribute('multiple') != undefined) {
        options = Object.assign(options, {
            plugins: {
                remove_button: {
                    title: 'Remove this item',
                }
            },
        })
    }

    if (localSaveStorage != undefined || localSaveStorage != null) {
        options = Object.assign(options, {
            items: localSaveStorage.split(","),
        })
    }

    new TomSelect(item, options);

    if (searchTableCloset) {
        let inputSearchTom = item.querySelector(`#${item.id}-ts-control`)
        if (inputSearchTom) {
            inputSearchTom.setAttribute('data-search-table', searchTableCloset);
        }
    }
}

document.querySelectorAll('.t-select').forEach(item => {
    newSelect(item)
})
