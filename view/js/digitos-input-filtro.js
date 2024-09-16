const yearInputs = document.querySelectorAll('.year-input');

  // Adiciona o evento de input para cada um dos inputs
  yearInputs.forEach(function(input) {
    input.addEventListener('input', function () {
      if (this.value.length > 4) {
        this.value = this.value.slice(0, 4); // Limita o valor a 4 caracteres
      }
    });
  });