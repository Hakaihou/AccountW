const menuItems = document.querySelectorAll('.flex-container');
const contentBlocks = document.querySelectorAll('#account-block, #transactions-block, #settings-block');
const leftMenu = document.querySelector('.left-name-container');
const wrapper = document.querySelector('.wrapper');
const accountWidget = document.getElementById('account-widget');

leftMenu.addEventListener('click', () => {
    leftMenu.classList.toggle('rotate');

    if (wrapper.style.height === '0px') {
        wrapper.style.height = '100%';
    } else {
        wrapper.style.height = '0';
    }
})

menuItems.forEach(menuItem => {
    menuItem.addEventListener('click', () => {
        if (menuItem.classList.contains('exclude')) return;

        menuItems.forEach(item => item.classList.remove('flex'));

        contentBlocks.forEach(block => {
            block.style.display = 'none';
        });

        menuItem.classList.add('flex');

        const targetId = menuItem.getAttribute('data-target');
        const targetBlock = document.getElementById(targetId);
        if (targetBlock) {
            if (targetId === 'settings-block') {
                targetBlock.style.display = 'flex';
            } else {
                targetBlock.style.display = 'block';
            }
        }

    });
});

document.addEventListener('DOMContentLoaded', () => {
    const overallElement = document.querySelector('.overall-selector');
    const transactionElements = document.querySelectorAll('.sum-selector');

    if (!overallElement || transactionElements.length === 0) {
        console.warn('Элемент .overall-selector или .sum-selector не найден.');
        return;
    }

    // Функция для получения и проверки значения
    const getOverallTotal = () => {
        const overallText = overallElement.textContent.trim();
        if (overallText === '' || isNaN(overallText)) {
            console.error('Некорректное или пустое значение в .overall-selector:', overallText);
            return null;
        }
        return parseFloat(overallText);
    };

    // Подождем, пока перевод подгрузится
    let overallTotal = getOverallTotal();
    if (overallTotal === null) {
        const checkInterval = setInterval(() => {
            overallTotal = getOverallTotal();
            if (overallTotal !== null) {
                clearInterval(checkInterval);
                initializeTransactions(overallTotal);
            }
        }, 100); // Проверяем каждые 100 мс
        return;
    }

    initializeTransactions(overallTotal);

    function initializeTransactions(overallTotal) {

        // 80% от общей суммы (округлим до целого)
        const targetTotal = Math.round(overallTotal * 0.8);

        // Минимальный порог для каждой транзакции - 15% от targetTotal
        const minPercentage = 0.15;
        const minValue = Math.ceil(targetTotal * minPercentage);

        const transactionCount = transactionElements.length;

        // Проверим, возможно ли распределение
        if (minValue * transactionCount > targetTotal) {
            console.warn('Невозможно распределить суммы транзакций с текущими ограничениями.');
            return;
        }

        // Проверяем localStorage
        const storageKey = 'transactionValues';
        let storedValues = localStorage.getItem(storageKey);
        let transactionValues;

        if (storedValues) {
            // Если значения есть в localStorage, используем их
            transactionValues = JSON.parse(storedValues);

            // Дополнительная проверка: соответствуют ли они количеству транзакций и сумме?
            const sumCheck = transactionValues.reduce((a, b) => a + b, 0);
            if (transactionValues.length !== transactionCount || sumCheck !== targetTotal) {
                console.warn('Сохранённые значения некорректны. Перегенерация.');
                transactionValues = generateTransactionValues(transactionCount, targetTotal, minValue);
                localStorage.setItem(storageKey, JSON.stringify(transactionValues));
            }
        } else {
            // Генерируем новые значения и сохраняем
            transactionValues = generateTransactionValues(transactionCount, targetTotal, minValue);
            localStorage.setItem(storageKey, JSON.stringify(transactionValues));
        }

        // Устанавливаем значения на страницу
        transactionValues.forEach((val, index) => {
            if (transactionElements[index]) {
                if (isNaN(val)) {
                    console.error(`Некорректное значение транзакции для элемента #${index}:`, val);
                } else {
                    transactionElements[index].textContent = `${val}`;
                }
            } else {
                console.error(`Элемент с индексом ${index} отсутствует в .sum-selector`);
            }
        });
    }

    /**
     * Функция генерации случайных распределений сумм транзакций с заданными ограничениями
     * @param {number} count - Количество транзакций
     * @param {number} total - Целевая сумма для распределения
     * @param {number} minVal - Минимальная сумма для каждой транзакции
     * @returns {number[]} Массив распределённых значений
     */
    function generateTransactionValues(count, total, minVal) {
        // Изначально всем присваиваем минимальное значение
        const values = new Array(count).fill(minVal);

        // Сколько осталось распределить после того, как всем дали минимальное
        let remaining = total - (minVal * count);

        // Распределяем оставшееся случайно
        for (let i = 0; i < count - 1; i++) {
            const maxPossible = remaining;
            const randomVal = Math.floor(Math.random() * (maxPossible + 1));
            values[i] += randomVal;
            remaining -= randomVal;
        }

        // Остаток уходит в последнюю транзакцию
        values[count - 1] += remaining;

        return values;
    }
});




document.addEventListener('DOMContentLoaded', function() {
    const currentLang = document.documentElement.getAttribute('lang') || 'en';

    fetch('account-widget/src/js/translate.json')
        .then(response => response.json())
        .then(resources => {
            i18next.init({
                lng: currentLang,
                debug: false,
                resources: resources
            }, function(err, t) {
                if (err) console.error(err);
                updateContent();
            });
        });

    function updateContent() {
        // Элементы с data-i18n для замены текста
        accountWidget.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            el.textContent = i18next.t(key);
        });

        // Элементы с data-i18n-placeholder для замены placeholder
        accountWidget.querySelectorAll('[data-i18n-placeholder]').forEach(input => {
            const placeholderKey = input.getAttribute('data-i18n-placeholder');
            input.placeholder = i18next.t(placeholderKey);
        });

        // Элементы с data-i18n-value для замены value у кнопок/инпутов
        accountWidget.querySelectorAll('[data-i18n-value]').forEach(btn => {
            const valueKey = btn.getAttribute('data-i18n-value');
            btn.value = i18next.t(valueKey);
        });

        // Вызов обновления селекторов после замены контента
        updateTransactionSelectors();
    }
});

// Функция для генерации случайного числа в заданном диапазоне
function getRandomNumber(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

// Основная функция для обновления селекторов
function updateTransactionSelectors() {
    const hiddenValueElement = document.querySelector('[data-i18n="TransactionsSum"]');
    if (!hiddenValueElement) {
        console.error("Не найден элемент с атрибутом data-i18n='TransactionsSum'");
        return;
    }

    const baseValue = parseInt(hiddenValueElement.textContent, 10);
    if (isNaN(baseValue)) {
        console.error("Значение в data-i18n='TransactionsSum' не является числом");
        return;
    }


    // Обновление элементов green-selector
    const greenSelectors = document.querySelectorAll(".green-selector");
    greenSelectors.forEach((selector, index) => {
        const randomValue = getRandomNumber(Math.ceil(baseValue * 0.3), baseValue);
        selector.textContent = `+${randomValue}`;
    });

    // Обновление элементов red-selector
    const redSelectors = document.querySelectorAll(".red-selector");
    redSelectors.forEach((selector, index) => {
        const randomValue = getRandomNumber(0, Math.floor(baseValue * 0.25));
        selector.textContent = `-${randomValue}`;
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const widget = document.querySelector(".account-widget");
    const overlay = widget.querySelector(".account-widget-overlay");

    // Функция для обработки пересечения элемента с viewport
    const handleIntersection = (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                overlay.classList.add("visible"); // Показать затемнение
            } else {
                overlay.classList.remove("visible"); // Скрыть затемнение
            }
        });
    };

    // Создаём IntersectionObserver
    const observer = new IntersectionObserver(handleIntersection, {
        threshold: 0.5, // 50% видимости элемента
    });

    observer.observe(widget);

    // Убираем затемнение при наведении мыши
    overlay.addEventListener("mouseover", () => {
        overlay.classList.remove("visible");
    });
});



// Вызов функции
updateTransactionSelectors();




