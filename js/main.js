const navbar = document.querySelector('.header-nav-bar');
const lightModeOn = (event) => {
  navbar.classList.add('header-nav-bar-scrol');
};

const lightModeOff = (event) => {
  navbar.classList.remove('header-nav-bar-scrol');
}
window.addEventListener('scroll', () => {
  this.scrollY > 3 ?  lightModeOn() : lightModeOff();
});



// START Modal
const modalController = ({ modal, btnOpen, btnClose, time = 300 }) => {
  // Находим все элементы с указанным селектором btnOpen
  const buttonElems = document.querySelectorAll(btnOpen);

  // Находим элемент с указанным селектором modal
  const modalElem = document.querySelector(modal);

  // Инициализируем модальное окно со стилями по умолчанию (скрытым)
  modalElem.style.cssText = `
    display: flex;
    visibility: hidden;
    opacity: 0;
    transition: opacity ${time}ms ease-in-out;
  `;

  // Функция для закрытия модального окна
  const closeModal = event => {
    const target = event.target;

    // Проверяем, был ли клик на модальном окне или кнопке закрытия, или была нажата клавиша Esc
    if (
      target === modalElem ||
      (btnClose && target.closest(btnClose)) ||
      event.code === 'Escape'
    ) {
      // Начинаем закрывать модальное окно, устанавливая opacity в 0
      modalElem.style.opacity = 0;

      // После времени перехода полностью скрываем модальное окно
      setTimeout(() => {
        modalElem.style.visibility = 'hidden';
      }, time);

      // Удаляем слушатель keydown, чтобы предотвратить бесконечные циклы
      window.removeEventListener('keydown', closeModal);
    }
  };

  // Функция для открытия модального окна
  const openModal = () => {
    // Показываем модальное окно, устанавливая visibility и opacity в 1
    modalElem.style.visibility = 'visible';
    modalElem.style.opacity = 1;

    // Добавляем слушатель keydown, чтобы закрыть модальное окно при нажатии клавиши Esc
    window.addEventListener('keydown', closeModal);
  };

  // Добавляем слушатель click к каждой кнопке, чтобы открыть модальное окно при клике
  buttonElems.forEach(btn => {
    btn.addEventListener('click', openModal);
  });

  // Добавляем слушатель click к модальному окну, чтобы закрыть его при клике
  modalElem.addEventListener('click', closeModal);
};

// Инициализируем контроллер модального окна с указанными селекторами
modalController({
  modal: '.modal1',
  btnOpen: '.section__button1',
  btnClose: '.modal__close',
});
// END Modal




// Start calc
const display = document.querySelector('.calc-display input');
const numbers = document.querySelectorAll('.calc-keyboard-num__nums');
const operators = document.querySelectorAll('.calc-keyboard-operation__operator');
// Получаем кнопку CE
const ceButton = document.querySelector('.calc-keyboard-operation__ce');


// Переменные для хранения чисел и оператора
let num1 = '';
let num2 = '';
let operator = '';

// Функция для обновления дисплея
function updateDisplay(num) {
  if (num1 && operator) {
    num2 += num;
    display.value = num1 + operator + num2;
  } else {
    num1 += num;
    display.value = num1;
  }
}

// Функция для выполнения операции
function calculate() {
  if (num1 && num2 && operator) {
    let result;
    switch (operator) {
      case '+':
        result = parseFloat(num1) + parseFloat(num2);
        break;
      case '-':
        result = parseFloat(num1) - parseFloat(num2);
        break;
      case '/':
        result = parseFloat(num1) / parseFloat(num2);
        break;
      case '*':
        result = parseFloat(num1) * parseFloat(num2);
        break;
      default:
        result = 0;
    }
    display.value = result;
    num1 = result.toString();
    num2 = '';
    operator = '';
  }
}

// События для кнопок с цифрами
numbers.forEach((number) => {
  number.addEventListener('click', () => {
    updateDisplay(number.textContent);
  });
});

// События для кнопок с операторами
operators.forEach((op) => {
  op.addEventListener('click', () => {
    if (op.textContent === '=') {
      calculate();
    } else if (num1 &&!operator) {
      operator = op.textContent;
      display.value = num1 + operator;
    }
  });
});

// Событие для кнопки CE
ceButton.addEventListener('click', () => {
    num1 = '';
    num2 = '';
    operator = '';
    display.value = '';
    display.placeholder = '_'; // Если вы хотите очистить текст-заполнитель
  });