(() => {
    'use strict';

    const page = document.getElementById('custom-collections');
    if (!page) return;

    const data = JSON.parse(page.querySelector('#cc-data').textContent);
    const grid = page.querySelector('#cc-product-grid');
    const template = page.querySelector('#cc-product-template');
    const dialog = page.querySelector('#cc-selection-dialog');
    const sort = page.querySelector('#cc-sort');
    const money = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 0 });
    const state = { collection: 'signature', size: 'all', colors: new Map() };

    function renderProducts() {
        const products = data.products[state.collection].filter(product => state.size === 'all' || product.size === state.size);
        if (sort.value !== 'featured') {
            products.sort((a, b) => sort.value === 'price-asc' ? a.price - b.price : b.price - a.price);
        }

        const fragment = document.createDocumentFragment();
        products.forEach(product => {
            const card = template.content.firstElementChild.cloneNode(true);
            card.dataset.product = product.id;
            card.querySelector('h3').textContent = product.name;
            card.querySelector('.cc-product-size').textContent = product.label;
            card.querySelector('.cc-product-price').textContent = money.format(product.price);
            const image = card.querySelector('svg');
            image.setAttribute('viewBox', product.crop);
            image.setAttribute('aria-label', `${product.name} photo arrangement in a neutral home`);
            image.querySelector('image').setAttribute('href', data.image);
            card.querySelector('.cc-colors').setAttribute('aria-label', `${product.name} colour`);
            card.querySelectorAll('[data-color]').forEach(button => {
                button.setAttribute('aria-pressed', String(button.dataset.color === (state.colors.get(product.id) || 'Black')));
            });
            card.querySelector('.cc-create').setAttribute('aria-label', `Create your ${product.name}`);
            fragment.append(card);
        });
        grid.replaceChildren(fragment);
        page.querySelector('#cc-empty').hidden = products.length > 0;
        page.querySelector('#cc-results-status').textContent = `${data.collections[state.collection].name}: ${products.length} products${state.size === 'all' ? '' : ` in ${state.size.replace('x', '×')}`}.`;
    }

    page.querySelectorAll('[data-collection]').forEach(button => {
        button.addEventListener('click', () => {
            state.collection = button.dataset.collection;
            const collection = data.collections[state.collection];
            page.querySelectorAll('[data-collection]').forEach(item => {
                const selected = item === button;
                item.classList.toggle('is-selected', selected);
                item.setAttribute('aria-pressed', String(selected));
            });
            page.querySelector('#cc-collection-eyebrow').textContent = `THE ${collection.name.toUpperCase()}`;
            page.querySelector('#cc-collection-heading').textContent = collection.tagline;
            page.querySelector('#cc-collection-description').textContent = collection.description;
            renderProducts();
        });
    });

    page.querySelectorAll('[data-size]').forEach(button => {
        button.addEventListener('click', () => {
            state.size = button.dataset.size;
            page.querySelectorAll('[data-size]').forEach(item => {
                item.classList.toggle('is-active', item === button);
                item.setAttribute('aria-pressed', String(item === button));
            });
            renderProducts();
        });
    });

    sort.addEventListener('change', renderProducts);
    grid.addEventListener('click', event => {
        const card = event.target.closest('[data-product]');
        if (!card) return;
        const color = event.target.closest('[data-color]');
        if (color) {
            state.colors.set(card.dataset.product, color.dataset.color);
            card.querySelectorAll('[data-color]').forEach(button => button.setAttribute('aria-pressed', String(button === color)));
            page.querySelector('#cc-results-status').textContent = `${card.querySelector('h3').textContent}: ${color.dataset.color} selected.`;
        }
        if (event.target.closest('.cc-create')) {
            const product = data.products[state.collection].find(item => item.id === card.dataset.product);
            page.querySelector('#cc-dialog-title').textContent = product.name;
            page.querySelector('#cc-dialog-details').textContent = `${product.label} · ${state.colors.get(product.id) || 'Black'} · ${money.format(product.price)}`;
            dialog.showModal();
        }
    });

    dialog.addEventListener('click', event => {
        if (event.target !== dialog) return;
        const bounds = dialog.getBoundingClientRect();
        if (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom) dialog.close();
    });

    renderProducts();
})();
