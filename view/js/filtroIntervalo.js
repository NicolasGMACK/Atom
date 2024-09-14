document.getElementById('openIntervalo').addEventListener('click', function() {
    var intervalo = document.querySelector('.intervalo');
    var openIntervalo = document.getElementById('openIntervalo');
    
    // Obter o valor de display calculado
    var currentDisplay = window.getComputedStyle(intervalo).display;
    
    if (currentDisplay === 'flex') {
        intervalo.style.display = 'none';
        openIntervalo.classList.remove('open');
        openIntervalo.classList.add('closed');
    } else {
        intervalo.style.display = 'flex';
        openIntervalo.classList.remove('closed');
        openIntervalo.classList.add('open');
    }
});

// Inicialmente, definir a classe closed para o texto
document.getElementById('openIntervalo').classList.add('closed');
