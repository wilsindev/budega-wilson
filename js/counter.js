    function startCounter(counter) {
        const target   = parseFloat(counter.dataset.target);
        const decimal  = counter.dataset.decimal === 'true';
        const duration = 1000;
        let startTime  = null;

        const format = (val) => val.toLocaleString('pt-BR', {
            minimumFractionDigits: decimal ? 2 : 0,
            maximumFractionDigits: decimal ? 2 : 0
        });

        function update(currentTime) {
            if (!startTime) startTime = currentTime;

            const progress = Math.min((currentTime - startTime) / duration, 1);
            counter.innerText = format(progress * target);

            if (progress < 1) requestAnimationFrame(update);
            else counter.innerText = format(target);
        }

        requestAnimationFrame(update);
    }

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                startCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    });

    document.querySelectorAll('.counter').forEach(counter => {
        counterObserver.observe(counter);
    });
