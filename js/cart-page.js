document.addEventListener('DOMContentLoaded', function () {
    if (!window.CartStorage) return;

    var products = Array.isArray(window.ALL_PRODUCTS_FOR_CART) ? window.ALL_PRODUCTS_FOR_CART : [];

    var emptyBlock = document.getElementById('cart-empty');
    var listBlock = document.getElementById('cart-list');
    var sidebar = document.getElementById('cart-sidebar');
    var clearBtn = document.getElementById('cart-clear');
    var printBtn = document.getElementById('cart-print');
    var checkoutOpenBtn = document.getElementById('cart-checkout-open');
    var checkoutModal = document.getElementById('cartCheckoutModal');
    var checkoutCloseBtn = document.getElementById('cart-checkout-close');
    var checkoutForm = document.getElementById('cart-checkout-form');
    var checkoutStatus = document.getElementById('cart-checkout-status');

    function getCartRows() {
        var cart = window.CartStorage.readItems();
        return cart
            .map(function (item) {
                var product = products.find(function (p) { return String(p.id) === String(item.id); });
                if (!product) return null;
                return { product: product, qty: item.qty };
            })
            .filter(Boolean);
    }

    function esc(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function render() {
        var rows = getCartRows();
        if (!rows.length) {
            emptyBlock.style.display = 'block';
            listBlock.style.display = 'none';
            sidebar.style.display = 'none';
            listBlock.innerHTML = '';
            return;
        }

        emptyBlock.style.display = 'none';
        listBlock.style.display = 'block';
        sidebar.style.display = 'flex';

        var html = '';
        rows.forEach(function (row) {
            var p = row.product;
            html += '<div class="cart-item">';
            html += '<div class="cart-item__img"><a href="/product/' + encodeURIComponent(p.slug || '') + '"><img src="' + esc(p.image || 'products/medikator.jpg') + '" alt="' + esc(p.name) + '"></a></div>';
            html += '<div class="cart-item__body">';
            html += '<div class="cart-item__name"><a href="/product/' + encodeURIComponent(p.slug || '') + '">' + esc(p.name) + '</a></div>';
            html += '<div class="cart-item__meta">Серия: ' + esc(p.series || '-') + '</div>';
            html += '<div class="cart-item__qty">';
            html += '<button type="button" data-cart-minus="' + esc(p.id) + '">-</button>';
            html += '<span>' + esc(row.qty) + '</span>';
            html += '<button type="button" data-cart-plus="' + esc(p.id) + '">+</button>';
            html += '</div></div>';
            html += '<button type="button" class="cart-item__remove" data-cart-remove="' + esc(p.id) + '">Удалить</button>';
            html += '</div>';
        });
        listBlock.innerHTML = html;
    }

    function orderText() {
        var rows = getCartRows();
        if (!rows.length) return 'Корзина пуста';
        return rows.map(function (row) {
            return '- ' + row.product.name + ' (x' + row.qty + ')';
        }).join('\n');
    }

    function setCheckoutStatus(message, isError) {
        checkoutStatus.textContent = message;
        checkoutStatus.classList.toggle('is-error', !!isError);
        checkoutStatus.classList.toggle('is-success', !isError);
    }

    function openCheckout() {
        checkoutModal.classList.add('is-active');
        checkoutModal.setAttribute('aria-hidden', 'false');
    }

    function closeCheckout() {
        checkoutModal.classList.remove('is-active');
        checkoutModal.setAttribute('aria-hidden', 'true');
    }

    document.addEventListener('click', function (event) {
        var removeBtn = event.target.closest('[data-cart-remove]');
        if (removeBtn) {
            window.CartStorage.removeItem(removeBtn.getAttribute('data-cart-remove'));
            window.CartStorage.syncButtons();
            window.CartStorage.updateCounter();
            render();
            return;
        }

        var plusBtn = event.target.closest('[data-cart-plus]');
        if (plusBtn) {
            window.CartStorage.addItem(plusBtn.getAttribute('data-cart-plus'), 1);
            window.CartStorage.syncButtons();
            window.CartStorage.updateCounter();
            render();
            return;
        }

        var minusBtn = event.target.closest('[data-cart-minus]');
        if (minusBtn) {
            var id = minusBtn.getAttribute('data-cart-minus');
            var nextQty = Math.max(0, window.CartStorage.getQtyById(id) - 1);
            window.CartStorage.setItemQty(id, nextQty);
            window.CartStorage.syncButtons();
            window.CartStorage.updateCounter();
            render();
        }
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            window.CartStorage.clearCart();
            window.CartStorage.syncButtons();
            window.CartStorage.updateCounter();
            render();
        });
    }

    if (printBtn) {
        printBtn.addEventListener('click', function () {
            window.print();
        });
    }

    if (checkoutOpenBtn) {
        checkoutOpenBtn.addEventListener('click', openCheckout);
    }
    if (checkoutCloseBtn) {
        checkoutCloseBtn.addEventListener('click', closeCheckout);
    }

    if (checkoutModal) {
        checkoutModal.addEventListener('click', function (event) {
            if (event.target === checkoutModal) closeCheckout();
        });
    }

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function (event) {
            event.preventDefault();
            var rows = getCartRows();
            if (!rows.length) {
                setCheckoutStatus('Корзина пуста', true);
                return;
            }

            var submitBtn = checkoutForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            setCheckoutStatus('Отправляем заказ...', false);

            var fd = new FormData(checkoutForm);
            var userMessage = fd.get('message') || '';
            var payloadMessage = (userMessage ? (userMessage + '\n\n') : '') + 'Состав заказа:\n' + orderText();
            fd.set('message', payloadMessage);

            fetch('includes/bitrix_form.php', {
                method: 'POST',
                body: fd
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data && data.success) {
                    setCheckoutStatus(data.message || 'Заказ отправлен', false);
                    checkoutForm.reset();
                    window.CartStorage.clearCart();
                    window.CartStorage.syncButtons();
                    window.CartStorage.updateCounter();
                    render();
                    setTimeout(closeCheckout, 1000);
                } else {
                    setCheckoutStatus((data && data.message) || 'Ошибка отправки', true);
                }
            })
            .catch(function () {
                setCheckoutStatus('Ошибка сети. Попробуйте еще раз.', true);
            })
            .finally(function () {
                submitBtn.disabled = false;
            });
        });
    }

    render();
});
