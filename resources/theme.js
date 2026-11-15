// Interaksi ringan tema Starter tanpa framework.

// Tombol buka/tutup: <button data-toggle="id-target">
document.addEventListener('click', (event) => {
    const trigger = event.target.closest('[data-toggle]');
    if (!trigger) return;

    const target = document.getElementById(trigger.dataset.toggle);
    if (!target) return;

    const isHidden = target.classList.toggle('hidden');
    trigger.setAttribute('aria-expanded', String(!isHidden));
});

// Dropdown menu berbasis <details data-dropdown>: tutup saat klik di luar.
document.addEventListener('click', (event) => {
    document.querySelectorAll('details[data-dropdown][open]').forEach((dropdown) => {
        if (!dropdown.contains(event.target)) dropdown.removeAttribute('open');
    });
});

// Akordeon: <div data-accordion="single"> hanya membiarkan satu <details> terbuka.
document.querySelectorAll('[data-accordion="single"]').forEach((accordion) => {
    accordion.addEventListener('toggle', (event) => {
        if (!event.target.open) return;
        accordion.querySelectorAll('details[open]').forEach((item) => {
            if (item !== event.target) item.removeAttribute('open');
        });
    }, true);
});

// Slider: <div data-slider data-interval="5000"> berisi [data-slide], [data-slider-prev|next], [data-slider-dot].
document.querySelectorAll('[data-slider]').forEach((slider) => {
    const slides = [...slider.querySelectorAll('[data-slide]')];
    const dots = [...slider.querySelectorAll('[data-slider-dot]')];
    if (slides.length < 2) return;

    let current = 0;
    let timer = null;

    const show = (index) => {
        current = (index + slides.length) % slides.length;
        slides.forEach((slide, i) => {
            slide.classList.toggle('opacity-0', i !== current);
            slide.classList.toggle('pointer-events-none', i !== current);
            slide.setAttribute('aria-hidden', String(i !== current));
        });
        dots.forEach((dot, i) => dot.setAttribute('aria-current', String(i === current)));
    };

    const restart = () => {
        const interval = Number(slider.dataset.interval || 0);
        clearInterval(timer);
        if (interval > 0) timer = setInterval(() => show(current + 1), interval);
    };

    slider.querySelector('[data-slider-prev]')?.addEventListener('click', () => { show(current - 1); restart(); });
    slider.querySelector('[data-slider-next]')?.addEventListener('click', () => { show(current + 1); restart(); });
    dots.forEach((dot, i) => dot.addEventListener('click', () => { show(i); restart(); }));

    show(0);
    restart();
});

// Filter galeri: tombol [data-filter="kategori"] menyaring item [data-filter-item="kategori"].
document.querySelectorAll('[data-filter-group]').forEach((group) => {
    const buttons = group.querySelectorAll('[data-filter]');
    const items = group.querySelectorAll('[data-filter-item]');

    buttons.forEach((button) => button.addEventListener('click', () => {
        const value = button.dataset.filter;
        buttons.forEach((b) => b.setAttribute('aria-pressed', String(b === button)));
        items.forEach((item) => {
            item.classList.toggle('hidden', value !== 'all' && item.dataset.filterItem !== value);
        });
    }));
});
