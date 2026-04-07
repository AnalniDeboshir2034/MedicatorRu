document.addEventListener('DOMContentLoaded', function () {
    var STORAGE_KEY = 'medicator_compare_ids';
    var MAX_COMPARE = 4;

    function readIds() {
        try {
            var raw = localStorage.getItem(STORAGE_KEY);
            var parsed = raw ? JSON.parse(raw) : [];
            if (!Array.isArray(parsed)) return [];
            return parsed.map(function (id) { return String(id); });
        } catch (e) {
            return [];
        }
    }

    function saveIds(ids) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));
    }

    function isInCompare(id) {
        return readIds().includes(String(id));
    }

    function updateButtonState(button, active) {
        if (!button) return;
        button.classList.toggle('is-active', active);
        button.textContent = active ? 'Убрать из сравнения' : 'В сравнение';
    }

    function syncButtons() {
        var ids = readIds();
        var buttons = document.querySelectorAll('[data-compare-id]');
        buttons.forEach(function (button) {
            var id = button.getAttribute('data-compare-id');
            updateButtonState(button, ids.includes(String(id)));
        });
    }

    function updateCounter() {
        var count = readIds().length;
        var counters = document.querySelectorAll('[data-compare-count]');
        counters.forEach(function (counter) {
            counter.textContent = String(count);
        });
    }

    document.addEventListener('click', function (event) {
        var button = event.target.closest('[data-compare-id]');
        if (!button) return;

        event.preventDefault();
        var id = String(button.getAttribute('data-compare-id') || '');
        if (!id) return;

        var ids = readIds();
        var index = ids.indexOf(id);

        if (index !== -1) {
            ids.splice(index, 1);
        } else {
            if (ids.length >= MAX_COMPARE) {
                alert('Можно сравнить максимум 4 товара');
                return;
            }
            ids.push(id);
        }

        saveIds(ids);
        syncButtons();
        updateCounter();
    });

    window.CompareStorage = {
        key: STORAGE_KEY,
        readIds: readIds,
        saveIds: saveIds,
        isInCompare: isInCompare,
        syncButtons: syncButtons,
        updateCounter: updateCounter
    };

    syncButtons();
    updateCounter();
});
