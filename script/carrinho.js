const quantidade = document.getElementById('quantidade');
const aumentarButton = document.getElementById('aumentar');
const diminuirButton = document.getElementById('diminuir');

let count = 0;
let intervalId = 0;

const updateValue = () => {
    quantidade.innerHTML = count;
};

aumentarButton.addEventListener('mousedown', () => {
    intervalId = setInterval(() => {
        count += 1;
        updateValue();
    }, 100);
});

diminuirButton.addEventListener('mousedown', () => {
    intervalId = setInterval(() => {
        if (count > 0) {
            count -= 1;
            updateValue();
        }
    }, 100);
});

document.addEventListener('mouseup', () => clearInterval(intervalId));

