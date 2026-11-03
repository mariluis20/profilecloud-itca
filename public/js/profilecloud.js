document.addEventListener('DOMContentLoaded', () => {
    const nav = document.getElementById('mainNav');
    const onScroll = () => nav && nav.classList.toggle('is-scrolled', window.scrollY > 10);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    const animateCount = (el) => {
        const target = parseInt(el.dataset.count, 10) || 0;
        const duration = 1400;
        const start = performance.now();
        const step = (now) => {
            const p = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased).toLocaleString('es-SV');
            if (p < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };

    const fillBars = (root) => {
        root.querySelectorAll('.pc-bar span[data-width]').forEach((bar) => {
            bar.style.width = bar.dataset.width + '%';
        });
    };

    const reveal = (el) => {
        el.classList.add('is-visible');
        if (el.matches('[data-count]')) animateCount(el);
        el.querySelectorAll('[data-count]').forEach(animateCount);
        fillBars(el);
    };

    const targets = document.querySelectorAll('.reveal, [data-count]');
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    reveal(entry.target);
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        targets.forEach((el) => {
            if (el.matches('[data-count]') && el.closest('.reveal')) return;
            io.observe(el);
        });
    } else {
        targets.forEach(reveal);
    }

    document.querySelectorAll('.pc-toast').forEach((toast, i) => {
        setTimeout(() => {
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 450);
        }, 5000 + i * 400);
        const close = toast.querySelector('[data-close]');
        if (close) close.addEventListener('click', () => toast.remove());
    });

    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photoPreview');
    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', () => {
            const file = photoInput.files && photoInput.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            if (photoPreview.tagName === 'IMG') {
                photoPreview.src = url;
            } else {
                const img = document.createElement('img');
                img.src = url;
                img.id = 'photoPreview';
                img.className = photoPreview.className;
                img.alt = 'Vista previa';
                photoPreview.replaceWith(img);
            }
        });
    }

    document.querySelectorAll('[data-autosubmit]').forEach((el) => {
        el.addEventListener('change', () => el.form && el.form.submit());
    });

    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            if (!window.confirm(form.dataset.confirm)) e.preventDefault();
        });
    });

    document.querySelectorAll('[data-toggle-password]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.togglePassword);
            if (!input) return;
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.innerHTML = show ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });
    });
});
