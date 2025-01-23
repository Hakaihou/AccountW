//Минимальная длина телефонного номера без кода страны
const numberLength = 7;
const[language, region] = document.documentElement.getAttribute('lang').split('-'); 
const currGeo = document.documentElement.getAttribute('lang');

//Отправка формы
function sendForm(){
	const btns = document.querySelectorAll('.form__btn')
	btns.forEach(item => {
	   item.disabled = true;
	});
	return false;
 }



document.addEventListener("DOMContentLoaded", function(event) {

	loadTranslations(currGeo)

	//Если есть cookie autoLogin редиректнуть на этот url
		function checkAutoLogin(){
			if(getCookie('autoLogin')){
				const url = getCookie('autoLogin');
				const decodedUrl = decodeURIComponent(url)
				console.log(decodedUrl)
				
			//  window.location.href = decodedUrl;
			window.location.href = 'form/registered.php';
			}
		}
		checkAutoLogin();




	



	// Функция для определения оставшегося времени
	function getTimeRemaining(endtime) {
		let t = Date.parse(endtime) - Date.parse(new Date());
		let seconds = Math.floor((t / 1000) % 60);
		let minutes = Math.floor((t / 1000 / 60) % 60);
		let hours = Math.floor((t / (1000 * 60 * 60)) % 24);
		let days = Math.floor(t / (1000 * 60 * 60 * 24));
		return {
			total: t,
			days: days,
			hours: hours,
			minutes: minutes,
			seconds: seconds
		};
	}
	// Функция для инициализации часов
	function initializeClock(id, endtime) {
		// Функция для обновления времени на часах
		function updateClock() {
			var t = getTimeRemaining(endtime);

			if (t.total <= 0) {
				clearInterval(timeinterval);
				var deadline = new Date(Date.parse(new Date()) + 13500 * 1000);
				initializeClock('clockdiv', deadline);
			}

			// Обновление времени на всех элементах с классом "timer-date"
			let clock = document.querySelectorAll('.timer-date').forEach(item => {
				item.querySelector(".hour").innerHTML = ("0" + t.hours).slice(-2);
				item.querySelector(".minutes").innerHTML = ("0" + t.minutes).slice(-2);
				item.querySelector(".seconds").innerHTML = ("0" + t.seconds).slice(-2);
			});
		}

		updateClock();
		var timeinterval = setInterval(updateClock, 1000);
	}

	// Определение дедлайна
	var deadline = new Date(Date.parse(new Date()) + 13500 * 1000);

	// Инициализация часов с id "clockdiv" и указанным дедлайном
	initializeClock("clockdiv", deadline);

	// Обработчик клика на все ссылки, которые начинаются с символа '#'
	document.querySelectorAll("a[href^='#']").forEach(link => {
		link.addEventListener("click", function(e) {
			e.preventDefault();
			let href = this.getAttribute("href").substring(1);
			const scrollTarget = document.getElementById(href);
			const topOffset = 0;
			const elementPosition = scrollTarget.getBoundingClientRect().top;
			const offsetPosition = elementPosition - topOffset;

			// Плавная прокрутка к указанному элементу
			window.scrollBy({
				top: offsetPosition - 100,
				behavior: "smooth"
			});
		});
	});
});

	// Подставляем код телефона
function addMaskPhone() {

	const phones = document.querySelectorAll('.wv_phone');	
	if (phones) {
					const code = document.querySelector('input[name="phone"]').value;
					phones.forEach(function(phone) {
						phone.pattern = '(\\+)[0-9]{9,16}';
						phone.title = 'The phone must contain 7 to 10 digits only';
						phone.value = code; // Устанавливаем начальное значение поля
					
						
						phone.addEventListener('focusin', function() {
							this.value = code + this.value.slice(code.length);
						});

						phone.addEventListener('input', function() {
							let newValue = this.value.slice(code.length)
							    newValue = newValue.replace(/[^0-9]/g, '')
							if(newValue.length>=numberLength){
								phone.parentElement.classList.remove('invalid');
								phone.parentElement.classList.add('valid');
								phone.classList.remove('invalid');
								phone.classList.add('valid');
						
							}else{
								phone.parentElement.classList.remove('valid');
								phone.parentElement.classList.add('invalid');
								phone.classList.remove('valid');
								phone.classList.add('invalid');
							}
								
								if (newValue.length > 14) {
									newValue = newValue.slice(0, 14);
								}
								this.value = code + newValue
							if (this.value.indexOf(code) !== 0) {

								this.value = code + this.value.slice(code.length);								
							}
						});
					});
		}
	}
//Нажатие на кнопку в форме!
function checkCookies(event) {
	var input_wv_phone = document.querySelector('.wv_phone').value; // Значение из поля ввода
	var input_wv_name = document.querySelector('.wv_name').value; // Значение из поля ввода

	var cookieValue = getCookie('user_phone'); // Значение куки с именем "myCookie"
	if (cookieValue) {
		if (cookieValue === input_wv_phone) {
			event.preventDefault();
			var body = document.querySelector('body');
			var template = getTemplate(window.lang || 'en', 'recently_confirmed');
			body.insertAdjacentHTML('beforeend', template);
		} else {
			setCookie('user_phone', input_wv_phone, 60 * 60); //60 minutes
			setCookie('user_name', input_wv_name, 60 * 60); //60 minutes
		}
	} else {
		setCookie('user_phone', input_wv_phone, 60 * 60); //60 minutes
		setCookie('user_name', input_wv_name, 60 * 60); //60 minutes
	}
}


//отрисовка окна при существовании уже кука
function getTemplate(lang, msg) {
	var input_wv_phone = document.querySelector('.wv_phone').value; // Значение из поля ввода

	const phone_support = "Invalid phone!";
	const main_msg = input_wv_phone;

	const styles = '<style scoped> #order-in-progress__popup {\
				position: fixed;\
				left: 50%;\
				top: 50%;\
				z-index: 200;\
				transform: translateX(-50%) translateY(-50%);\
				 background: white;\
				 box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);\
				 font-family: inherit;\
				 font-size: 18px;\
				 text-align: center;\
				 display: flex;\
				 justify-content: center;\
				 align-items: center;\
				 flex-direction: column;\
				 max-width: 400px;\
				 width: 100%;\
				 height: auto;\
				 border-radius: 5px;\
				 padding: 30px;\
				}\
				#order-in-progress__popup button {\
				 background: #f57d02;\
				 border-radius: 3px;\
				 border: none;\
				 text-transform: uppercase;\
				 padding: 10px 20px;\
				 margin-top: 20px;\
				 font-weight: 700;\
				 color: white;\
				 font-size: 19px;\
				 font-family: inherit;\
				}\
				#order-in-progress__popup span {\
				 width: 100%;\
				}\
				@media screen and (max-width: 479px) {\
				 #order-in-progress__popup {\
					max-width: calc(90vw - 40px);\
					padding: 15px 20px;\
				 }\
				}</style>';
	return styles + '<div id="order-in-progress__popup" ' +
		'style="position: fixed; z-index: 2147483647;" >' +
		'<span>' + main_msg + ' ' + phone_support + '</span>' +
		'<button' +
		' style="background: #f57d02; border: 0px;margin-top: 30px; width: auto;"' +
		'  onclick="document.body.removeChild(document.querySelector(\'#order-in-progress__popup\'))">Close' +
		'</button>' +
		'</div>';
}


//Проверка существовании кука
function getCookie(name) {
	var cookies = document.cookie.split(';');
	for (var i = 0; i < cookies.length; i++) {
		var cookie = cookies[i].trim();
		if (cookie.startsWith(name + '=')) {
			return cookie.substring(name.length + 1);
		}
	}
	return null;
}

//отрисовка даты на страничке
function dtime_nums(offset) {
	const date = new Date();
	date.setDate(date.getDate() + offset);
	document.write(date.toLocaleDateString());
}

var loadingImage = document.getElementById('loading');

// Функция для проверки длины имени и фамилии и изменения стилей в соответствии с результатом
function validateInputLength(input) {
// let newValue = input.value.replace(/[^\w\s]|_/g, '');
// input.value = newValue;
	var value = input.value.trim();
	if (value.length < 2) {
		input.classList.remove('valid');
		input.classList.add('invalid');

		return false;
	} else {

		input.classList.remove('invalid');
		input.classList.add('valid');
	

		return true;
	}



	
}

// Функция для проверки допустимости адреса электронной почты
function validateEmail(input) {
	var email = input.value.trim();
	var emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	if (emailFormat.test(email)) {
		input.classList.remove('invalid');
		input.classList.add('valid');
		return true;
	} else {
		input.classList.remove('valid');
		input.classList.add('invalid');
		return false;
	}
}

// Обработчик событий на всех формах на странице
const forms = document.querySelectorAll('._signup_form')


//Все формы на странице
forms.forEach(form => {
	// Получаем ссылки на поля ввода и кнопку отправки формы
	const firstNameInput = form.querySelector('input[name="firstName"]');
	const lastNameInput = form.querySelector('input[name="lastName"]');
	const emailInput = form.querySelector('input[name="email"]');
	const submitButton = form.querySelector('input[type="submit"]');

	const inputs = form.querySelectorAll('.form__input');


inputs.forEach(input => {
input.addEventListener('input', ()=>{
	setTimeout(() => {
		const allValid = Array.from(inputs).every(input => input.classList.contains('valid'));
		// const valids = document.querySelectorAll('.valid');
		
		if (allValid) {
			submitButton.classList.add('active');
			submitButton.disabled = false;
		} else {
			submitButton.classList.remove('active');
			submitButton.disabled = true;
		}
	}, 0);
	
})

})
let stopword;
const forbiddenWords = ['scam', 'fuck', 'spam'];




function blackListWordCheck(value){
    const lowerCaseText = value.toLowerCase();
	stopword = forbiddenWords.some(word => lowerCaseText.includes(word));
}

// Добавляем обработчики событий для полей ввода имени, фамилии и email
	firstNameInput.addEventListener('input', function() {
		validateInputLength(this);
		blackListWordCheck(this.value)		
	});

	lastNameInput.addEventListener('input', function() {
		validateInputLength(this);
		blackListWordCheck(this.value)		
	})

	emailInput.addEventListener('input', function() {
	validateEmail(this);
	blackListWordCheck(this.value)		
	});




	form.addEventListener('submit', function(event) {
		// Валидация полей перед отправкой формы

		var isFirstNameValid = validateInputLength(firstNameInput);
		var isLastNameValid = validateInputLength(lastNameInput);
		var isEmailValid = validateEmail(emailInput);
	
		// Проверяем, все ли данные валидны
		if (isFirstNameValid && isLastNameValid && isEmailValid) {
			// Отключаем кнопку после первого нажатия
			submitButton.disabled = true;
	
			// Затемняем всю форму
			form.style.opacity = '0.3';
	
			// Показываем изображение загрузки
			loadingImage.style.display = 'block';
	
			// Отправляем данные формы
			form.submit();
		
		} else {
			// Если данные невалидные, отменяем отправку формы
			event.preventDefault();
		}
	});
})

//Асинхронная подгрузка переводов из json файла
async function loadTranslations(lang) {
    try {
        const response = await fetch('account-widget/widget-chat/form/translate/form.json');
        if (!response.ok) {
            throw new Error('Network error: ' + response.statusText);
        }
        const translations = await response.json();
        i18next.init({
            lng: lang,
            debug: false,
            resources: translations 
        }, function(err, t) {
            if (err) {
                console.error('Initialisation error i18next:', err);
            } else {          
             updateContent();
			 addMaskPhone()
            }
        });
    } catch (error) {
        console.error('translation loading error:', error);
    }
  }

  //Перевод формы
function updateContent() {

	const titles = document.querySelectorAll('.form__title');
			titles.forEach((title)=>{
				title.textContent = i18next.t('title');
			})

    
	const names = document.querySelectorAll('input[name="firstName"]');
			names.forEach((name)=>{
				name.placeholder = i18next.t('firstName');
			})
	const lastNames = document.querySelectorAll('input[name="lastName"]');
			lastNames.forEach((lastName)=>{
				lastName.placeholder = i18next.t('lastName');
			})

    const flags = document.querySelectorAll('.iti-flag');
		flags.forEach((flag)=>{
			if(flag.classList.length>1){
				flag.classList.replace(flag.classList[1], i18next.t('flag'));
			}else{
				flag.classList.add(i18next.t('flag'));
			}
		})


		const codes = document.querySelectorAll('input[name="phone"]');

			codes.forEach((code)=>{
				code.value = i18next.t('code');
			})


    const emails = document.querySelectorAll('input[name="email"]');
		emails.forEach((email)=>{
			email.placeholder = i18next.t('email');
		})


    const buttons = document.querySelectorAll('.form__btn');
	buttons.forEach((button)=>{
		button.value = i18next.t('button'); 
	})
    
    // countryCode.value = i18next.t(region);
    // languageCode.value = i18next.t(language);

    // if(flag.classList.length>1){
    //     flag.classList.replace(flag.classList[1], i18next.t('flag'));
    // }else{
    //     flag.classList.add(i18next.t('flag'));
    // }
	const countryCodes = document.querySelectorAll('input[name="countryCode"]');
    const languageCodes = document.querySelectorAll('input[name="langCode"]');

			countryCodes.forEach((countryCode)=>{
				countryCode.value = i18next.t(region);
			})

			languageCodes.forEach((languageCode)=>{
				languageCode.value = i18next.t(language);
			})
			
    // code.value = i18next.t('code');

	// Создаем cookie 
	setCookie('currentLanguage', `${language}`, 30);
}

function changeLanguage(language) {
    i18next.changeLanguage(language, updateContent);
}
//Установка куков
function setCookie(name, value, days) {
	const date = new Date();
	date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Устанавливаем срок действия cookie
	const expires = "expires=" + date.toUTCString();
	document.cookie = `${name}=${value}; ${expires}; path=/`;
}