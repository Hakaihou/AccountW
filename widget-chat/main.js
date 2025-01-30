document.addEventListener('DOMContentLoaded', function () {
    const newCity = document.getElementById('currentCity');

    let startChating = false;

    // Получаем элементы
    const widget = document.querySelector('.chat-widget');
    const currentForm = document.querySelector('.offer__link');
    const chatToggle = document.getElementById('chatToggle'); // чекбокс-переключатель
    const closeChat = document.querySelector('.chat-close-btn'); // кнопка закрытия чата

    let lastMessage = document.querySelector('.main-chat');
    const customForm = document.getElementById('leadform_form');
    const anchor = document.querySelector('.chat-widget');

    let answersArray = [];
    let counter = 0;
    let questionCounter = 0;
    let contentArray = [];
    let questions = [];
    let answers = [];
    let waiting = false;
    let intervalId;

    // Получаем текущий язык из атрибута lang в теге html
    const currentLang = document.documentElement.getAttribute('lang') || 'en';

    // Загружаем JSON данные через fetch
    fetch('account-widget/src/js/translate.json')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const translations = data[currentLang]?.translation;
            if (!translations) {
                throw new Error(`Переводы для языка ${currentLang} не найдены в JSON-файле.`);
            }
            contentArray = translations.contentArray || [];
            questions = translations.questions || [];
            answers = translations.answers || [];
            initializeChat();
        })
        .catch(error => {
            console.error('Ошибка загрузки JSON:', error);
        });

    function initializeChat() {
        // Слушатель на чекбокс
        chatToggle.addEventListener('change', () => {
            if (chatToggle.checked) {
                widget.classList.add('visible');
                if (!startChating) {
                    intervalId = setInterval(createDivWithInterval, 1200);
                }
                startChating = true;
            } else {
                widget.classList.remove('visible');
            }
        });

        // Слушатель на кнопку закрытия чата
        closeChat.addEventListener('click', () => {
            // Выключаем чекбокс
            chatToggle.checked = false;
            // Скрываем виджет
            widget.classList.remove('visible');
        });
    }

    function createDivWithInterval() {

        if (!contentArray || contentArray.length === 0) {
            console.error('Массив contentArray пуст или не определён.');
            clearInterval(intervalId);
            showFeedbackForm();
            return;
        }

        if (counter < contentArray.length) {
            let newMessage = document.createElement('div');
            newMessage.className = 'left-chat';
            anchor.scrollTop = anchor.scrollHeight;

            // Добавляем загрузчик
            newMessage.innerHTML = '<div class="chat-block"> <span class="chat-loader"><span></div>';
            customForm.before(newMessage);

            setTimeout(() => {
                if (contentArray[counter] !== undefined) {
                    newMessage.innerHTML =
                        '<img src="account-widget/widget-chat/images/latiino_assistant.jpg" />  <div class="chat-block">' + contentArray[counter] + '</div>';
                } else {
                    console.error('Сообщение undefined. Индекс:', counter);
                }
                anchor.scrollTop = anchor.scrollHeight;

                counter++; // Увеличиваем индекс только после отправки сообщения
            }, 800);
        } else {
            clearInterval(intervalId);
            anchor.scrollTop = anchor.scrollHeight;

            if (questions.length > 0) {
                postQuestion(
                    questions[questionCounter],
                    answers[questionCounter],
                    'vertical',
                    questionCounter
                );
            } else {
                showFeedbackForm();
            }
            waiting = true;
        }
    }

    function sendMessage(type, content) {
        let rotation = 'vertical';
        anchor.scrollTop = anchor.scrollHeight;

        if (type == 'button') {
            let newMessage = document.createElement('div');
            newMessage.className = 'right-chat';
            newMessage.innerHTML =
                '<div class="chat-block">' +
                content +
                '</div><input type="hidden" name="' +
                questions[questionCounter] +
                '" value="' +
                content +
                '">';
            customForm.before(newMessage);

            setTimeout(() => {
                anchor.scrollTop = anchor.scrollHeight;
            }, 1000);

            if (waiting) {
                setTimeout(function () {
                    questionCounter++;
                    let rotation = 'vertical';
                    anchor.scrollTop = anchor.scrollHeight;

                    if (questionCounter < questions.length) {
                        postQuestion(
                            questions[questionCounter],
                            answers[questionCounter],
                            rotation,
                            questionCounter
                        );
                    } else {
                        showFeedbackForm();
                    }
                }, 500);
                waiting = false;
            }
        } else {
            postQuestion(
                questions[questionCounter],
                answers[questionCounter],
                rotation,
                questionCounter
            );
        }
    }

    function postQuestion(question, answers, rotation) {
        anchor.scrollTop = anchor.scrollHeight;

        let newMessage = document.createElement('div');
        newMessage.className = 'left-chat message-index-' + questionCounter;
        newMessage.innerHTML = '<div class="chat-block"> <span class="chat-loader"><span> </div>';
        anchor.scrollTop = anchor.scrollHeight;
        customForm.before(newMessage);

        setTimeout(() => {
            anchor.scrollTop = anchor.scrollHeight;
            newMessage.innerHTML = '<img src="account-widget/widget-chat/images/latiino_assistant.jpg" /><div class="chat-block">' + question + '</div>';
            anchor.scrollTop = anchor.scrollHeight;
        }, 1000);

        if (answers) {
            let newButtons = document.createElement('div');
            newButtons.className = rotation;

            answers.forEach((item) => {
                let button = document.createElement('button');
                button.type = 'button';
                button.className = 'answer-btn answer-btn-' + questionCounter;
                button.innerHTML = item;

                setTimeout(() => {
                    newButtons.appendChild(button);
                    anchor.scrollTop = anchor.scrollHeight;
                }, 2000);

                button.addEventListener('click', function () {
                    waiting = true;
                    sendMessage('button', item);

                    let btns = document.querySelectorAll('.answer-btn-' + questionCounter);
                    btns.forEach(btn => {
                        btn.disabled = true;
                    });
                });
            });

            customForm.before(newButtons);
        } else {
            showFeedbackForm();
        }
    }

    function showFeedbackForm() {
        if (customForm) {
            customForm.classList.add('visible');
            anchor.scrollTop = anchor.scrollHeight;
        } else {
            console.error('Форма обратной связи не найдена.');
        }
    }
});